const root = document.querySelector('[data-realtime-module]');

if (root && window.Echo) {
    const moduloId = Number(root.dataset.realtimeModule);
    const estadoUrl = root.dataset.realtimeStateUrl;
    const estadoConexion = root.querySelector('[data-realtime-connection]');
    let timer = null;
    let ultimaVersion = 0;

    const mostrarConexion = (texto, estado) => {
        if (!estadoConexion) return;
        estadoConexion.textContent = texto;
        estadoConexion.dataset.state = estado;
    };

    const fechaLocal = (iso) => {
        if (!iso) return 'Sin datos recientes';
        const fecha = new Date(iso);
        return Number.isNaN(fecha.getTime()) ? 'Dato reciente' : fecha.toLocaleString();
    };

    const aplicarEstado = (data) => {
        if (!data?.ok || Number(data.version) < ultimaVersion) return;
        ultimaVersion = Number(data.version);

        const onlineText = root.querySelector('[data-module-online-text]');
        const onlineDot = root.querySelector('[data-module-online-dot]');
        const contactText = root.querySelector('[data-module-last-contact]');

        if (onlineText) onlineText.textContent = data.modulo.habilitado ? (data.modulo.online ? 'Online' : 'Offline') : 'Deshabilitado';
        if (onlineDot) onlineDot.classList.toggle('online', Boolean(data.modulo.online));
        if (onlineDot) onlineDot.classList.toggle('offline', !data.modulo.online);
        if (contactText) contactText.textContent = fechaLocal(data.modulo.ultimo_contacto);

        for (const sensor of data.sensores ?? []) {
            const card = root.querySelector(`[data-sensor-id="${sensor.id}"]`);
            if (!card) continue;

            const value = card.querySelector('[data-sensor-value]');
            const measured = card.querySelector('[data-sensor-measured]');
            const decimals = Number(card.dataset.decimals ?? 0);
            const unit = sensor.unidad || card.dataset.unit || '';

            if (value) {
                value.textContent = sensor.valor === null
                    ? `--${unit ? ` ${unit}` : ''}`
                    : `${Number(sensor.valor).toFixed(decimals)}${unit ? ` ${unit}` : ''}`;
            }
            if (measured) measured.textContent = fechaLocal(sensor.medido_en);
        }

        for (const actuator of data.actuadores ?? []) {
            const input = root.querySelector(`[data-actuator-id="${actuator.id}"]`);
            if (!input) continue;
            const desired = actuator.estado_deseado?.on;
            if (typeof desired === 'boolean' && !input.disabled) input.checked = desired;
            const text = input.closest('.toggle-pack')?.querySelector('.toggle-text');
            if (text && typeof desired === 'boolean') text.textContent = desired ? 'ON' : 'OFF';
        }
    };

    const recuperarEstado = async () => {
        if (!estadoUrl) return;
        try {
            const response = await window.axios.get(estadoUrl, { headers: { Accept: 'application/json' } });
            aplicarEstado(response.data);
        } catch (error) {
            mostrarConexion('Sin sincronización', 'error');
        }
    };

    const programarRecuperacion = () => {
        window.clearTimeout(timer);
        timer = window.setTimeout(recuperarEstado, 120);
    };

    const aplicarPresencia = (event) => {
        const presencia = event?.presencia;
        if (!presencia) return;

        const onlineText = root.querySelector('[data-module-online-text]');
        const onlineDot = root.querySelector('[data-module-online-dot]');
        const contactText = root.querySelector('[data-module-last-contact]');

        if (onlineText) onlineText.textContent = presencia.online ? 'Online' : 'Offline';
        if (onlineDot) onlineDot.classList.toggle('online', Boolean(presencia.online));
        if (onlineDot) onlineDot.classList.toggle('offline', !presencia.online);
        if (contactText && presencia.ultimo_contacto) contactText.textContent = fechaLocal(presencia.ultimo_contacto);
    };

    window.Echo.private(`modulos.${moduloId}`)
        .listen('.lectura.registrada', programarRecuperacion)
        .listen('.comando.actualizado', programarRecuperacion)
        .listen('.actuador.actualizado', programarRecuperacion)
        .listen('.modulo.presencia', aplicarPresencia)
        .error(() => mostrarConexion('Canal no autorizado', 'error'));

    const connection = window.Echo.connector?.pusher?.connection;
    connection?.bind('connected', () => {
        mostrarConexion('Tiempo real conectado', 'connected');
        recuperarEstado();
    });
    connection?.bind('disconnected', () => mostrarConexion('Reconectando…', 'disconnected'));
    connection?.bind('error', () => mostrarConexion('Error WebSocket', 'error'));
}
