<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Arquitectura híbrida de comunicación web y telemetría en entornos IoT | MecaCuy</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('landing/assets/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('landing/assets/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landing/assets/images/favicons/favicon-16x16.png') }}" />
    <meta name="description" content="Tesis de grado de la Universidad Pública de El Alto: arquitectura híbrida con HTTP, MQTT y WebSocket para gestionar dispositivos IoT, telemetría y comunicación web." />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/animate/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/jarallax/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/odometer/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/swiper/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/agrion-icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/vendors/owl-carousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/css/agrion.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/css/agrion-responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/assets/css/agrion-dark.css') }}" />
    <style>
        .project-badge {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            color: #fff;
            font-size: 14px;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .mini-card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 24px;
            height: 100%;
        }
        .mini-card h4,
        .mini-card p,
        .problem-card h4,
        .problem-card p { color: #fff; }
        .problem-card {
            background: #0f111b;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            padding: 28px;
            height: 100%;
        }
        .section-space { padding: 120px 0; }
        .text-justify { text-align: justify; }
        .icon-box-custom {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #161a59cc;
            color: #fff;
            font-size: 28px;
            margin-bottom: 18px;
        }
        .metric-box {
            text-align: center;
            padding: 28px 20px;
            border-radius: 18px;
            background: #111c15;
            border: 1px solid rgba(255,255,255,.06);
            height: 100%;
        }
        .metric-box h3,
        .metric-box p { color: #fff; }
        .main-menu__list a { cursor: pointer; }
    </style>
</head>
<body class="custom-cursor">

<div class="custom-cursor__cursor"></div>
<div class="custom-cursor__cursor-two"></div>

<div class="preloader">
    <div class="preloader__image"></div>
</div>

<div class="page-wrapper">
    <header class="main-header">
        <div class="main-header__wrapper">
            <div class="main-header__wrapper-inner">
                <div class="main-header__logo">
                    <a href="#inicio"><img src="{{ asset('landing/assets/images/resources/logo-1.png') }}" alt="MecaCuy"></a>
                </div>
                <div class="main-header__menu-box">
                    <div class="main-header__menu-box-bottom">
                        <nav class="main-menu">
                            <div class="main-menu__wrapper">
                                <div class="main-menu__wrapper-inner">
                                    <div class="main-menu__left">
                                        <div class="main-menu__main-menu-box">
                                            <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                                            <ul class="main-menu__list">
                                                <li><a href="#inicio">Inicio</a></li>
                                                <li><a href="#proyecto">Proyecto</a></li>
                                                <li><a href="#problema">Desafíos</a></li>
                                                <li><a href="#arquitectura">Arquitectura IoT</a></li>
                                                <li><a href="#modulos">Módulos</a></li>
                                                <li><a href="#beneficios">Evaluación</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="main-header__phone-contact-box">
                    <div class="main-header__phone-number">
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                    <div class="main-header__call-box">
                        <div class="main-header__call-inner">
                            <a href="{{ route('login') }}" class="main-header__call-icon">
                                <span class="fas fa-user"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="stricky-header stricked-menu main-menu">
        <div class="sticky-header__content"></div>
    </div>

    <section class="main-slider clearfix" id="inicio">
        <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView":1,"loop":true,"effect":"fade","pagination":{"el":"#main-slider-pagination","type":"bullets","clickable":true},"navigation":{"nextEl":"#main-slider__swiper-button-next","prevEl":"#main-slider__swiper-button-prev"},"autoplay":{"delay":5000}}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="image-layer" style="background-image: url({{ asset('landing/assets/images/backgrounds/main-slider-1-1.jpg') }});"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <p class="main-slider__sub-title">UNIVERSIDAD PÚBLICA DE EL ALTO · INGENIERÍA DE SISTEMAS</p>
                                    <h2 class="main-slider__title">Arquitectura híbrida</h2>
                                    <div class="main-slider__btn-box">
                                        <a href="{{ route('login') }}" class="thm-btn main-slider__btn">
                                            Ingresar a la plataforma <i class="icon-right-arrow"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="swiper-slide">
                    <div class="image-layer" style="background-image: url({{ asset('landing/assets/images/backgrounds/main-slider-1-2.jpg') }});"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <p class="main-slider__sub-title">UNIVERSIDAD PÚBLICA DE EL ALTO · INGENIERÍA DE SISTEMAS</p>
                                    <h2 class="main-slider__title">Monitoreo en entornos IoT</h2>
                                    <div class="main-slider__btn-box">
                                        <a href="{{ route('login') }}" class="thm-btn main-slider__btn">
                                            Ingresar a la plataforma <i class="icon-right-arrow"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="image-layer" style="background-image: url({{ asset('landing/assets/images/backgrounds/main-slider-1-3.jpg') }});"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <p class="main-slider__sub-title">UNIVERSIDAD PÚBLICA DE EL ALTO · INGENIERÍA DE SISTEMAS</p>
                                    <h2 class="main-slider__title">Telemetría y comunicación web</h2>
                                    <div class="main-slider__btn-box">
                                        <a href="{{ route('login') }}" class="thm-btn main-slider__btn">
                                            Ingresar a la plataforma <i class="icon-right-arrow"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-pagination" id="main-slider-pagination"></div>
            <div class="main-slider__nav">
                <div class="swiper-button-prev" id="main-slider__swiper-button-next"><i class="icon-right-arrow"></i></div>
                <div class="swiper-button-next" id="main-slider__swiper-button-prev"><i class="icon-right-arrow"></i></div>
            </div>
        </div>
    </section>

    <section class="feature-one">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="feature-one__single">
                        <div class="feature-one__icon"><span class="fas fa-microchip"></span></div>
                        <div class="feature-one__content"><h3 class="feature-one__title">Adquisición de datos <br> desde dispositivos IoT</h3></div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="feature-one__single">
                        <div class="feature-one__icon"><span class="fas fa-broadcast-tower"></span></div>
                        <div class="feature-one__content"><h3 class="feature-one__title">Telemetría MQTT <br> y eventos web</h3></div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="feature-one__single">
                        <div class="feature-one__icon"><span class="fas fa-clipboard-list"></span></div>
                        <div class="feature-one__content"><h3 class="feature-one__title">Lecturas, órdenes <br> y estados trazables</h3></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-one section-space" id="proyecto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="about-one__left">
                        <div class="section-title text-left">
                            <span class="section-title__tagline">Sobre el proyecto</span>
                            <h2 class="section-title__title">Comunicación web y telemetría para entornos IoT</h2>
                            <div class="section-title__icon">
                                <img src="{{ asset('landing/assets/images/icon/section-title-icon-1.png') }}" alt="icono">
                            </div>
                        </div>
                        <p class="about-one__text-2 text-justify">
                            La tesis propone una arquitectura híbrida de comunicación web con HTTP, MQTT y WebSocket. El sistema coordina la administración de dispositivos, la recepción y persistencia de telemetría, el envío de órdenes y la actualización de la interfaz. Un prototipo de monitoreo y control con ESP32 permite evaluar estos flujos en un entorno definido.
                        </p>
                        <ul class="list-unstyled about-one__points">
                            <li>
                                <div class="icon"><span class="icon-tick"></span></div>
                                <div class="text"><p>HTTP para la administración de dispositivos y las consultas de información.</p></div>
                            </li>
                            <li>
                                <div class="icon"><span class="icon-tick"></span></div>
                                <div class="text"><p>MQTT para intercambiar telemetría, órdenes y confirmaciones con los dispositivos.</p></div>
                            </li>
                            <li>
                                <div class="icon"><span class="icon-tick"></span></div>
                                <div class="text"><p>WebSocket para distribuir eventos y cambios de estado hacia la interfaz web.</p></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mini-card">
                                <div class="icon-box-custom"><i class="fas fa-microchip"></i></div>
                                <h4>Administración mediante HTTP</h4>
                                <p>HTTP permite realizar operaciones administrativas y consultar los registros de la plataforma.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mini-card">
                                <div class="icon-box-custom"><i class="fas fa-fan"></i></div>
                                <h4>Telemetría con MQTT</h4>
                                <p>MQTT conecta las publicaciones y órdenes del dispositivo con los servicios de la aplicación.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mini-card">
                                <div class="icon-box-custom"><i class="fas fa-database"></i></div>
                                <h4>Eventos con WebSocket</h4>
                                <p>WebSocket comunica eventos y cambios de estado a las sesiones web autorizadas.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mini-card">
                                <div class="icon-box-custom"><i class="fas fa-shield-alt"></i></div>
                                <h4>Prototipo con ESP32</h4>
                                <p>El banco de pruebas permite generar mediciones y observar la respuesta a las órdenes de control.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services-one section-space" id="problema">
        <div class="services-one__bg" style="background-image: url({{ asset('landing/assets/images/shapes/services-one-shape-1-dark.png') }});"></div>
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Contexto del problema</span>
                <h2 class="section-title__title">Desafíos que aborda la propuesta</h2>
                <div class="section-title__icon">
                    <img src="{{ asset('landing/assets/images/icon/section-title-icon-1.png') }}" alt="icono">
                </div>
            </div>
            <div class="row g-4">
                <div class="col-xl-6 col-lg-6">
                    <div class="problem-card">
                        <div class="icon-box-custom"><i class="fas fa-stopwatch"></i></div>
                        <h4>Latencia entre el dispositivo y la interfaz</h4>
                        <p>Una lectura recorre el dispositivo, la aplicación y el navegador. La investigación medirá su tránsito entre las etapas de comunicación.</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="problem-card">
                        <div class="icon-box-custom"><i class="fas fa-not-equal"></i></div>
                        <h4>Desincronización de estados</h4>
                        <p>Una lectura puede almacenarse antes de aparecer en pantalla. Los registros correlacionados permiten comparar la información de cada etapa.</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="problem-card">
                        <div class="icon-box-custom"><i class="fas fa-hourglass-half"></i></div>
                        <h4>Órdenes sin confirmación comprobable</h4>
                        <p>La aceptación de una solicitud no confirma por sí sola su recepción ni la ejecución de una orden en el dispositivo.</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="problem-card">
                        <div class="icon-box-custom"><i class="fas fa-redo-alt"></i></div>
                        <h4>Recuperación ante interrupciones</h4>
                        <p>Las pruebas previstas observarán la reconexión, la recuperación de los canales y la sincronización posterior.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="healthy-food-one section-space" id="arquitectura">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="healthy-food-one__left">
                        <div class="healthy-food-one__img">
                            <img src="{{ asset('landing/assets/images/resources/healthy-food-one-1.jpg') }}" alt="Arquitectura IoT">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="healthy-food-one__right">
                        <div class="section-title text-left">
                            <span class="section-title__tagline">Arquitectura IoT</span>
                            <h2 class="section-title__title">Capas funcionales del sistema</h2>
                            <div class="section-title__icon">
                                <img src="{{ asset('landing/assets/images/icon/section-title-icon-1.png') }}" alt="icono">
                            </div>
                        </div>
                        <p class="healthy-food-one__text text-justify">
                            La propuesta distribuye las responsabilidades de comunicación entre HTTP, MQTT y WebSocket. El backend valida y almacena las lecturas; los comandos quedan relacionados con sus confirmaciones, y los eventos actualizan la información presentada en la interfaz web.
                        </p>
                        <ul class="list-unstyled healthy-food-one__list">
                            <li class="healthy-food-one__single">
                                <div class="healthy-food-one__content">
                                    <div class="healthy-food-one__icon"><span class="fas fa-exchange-alt"></span></div>
                                    <p class="healthy-food-one__title">HTTP · administración y consultas</p>
                                </div>
                            </li>
                            <li class="healthy-food-one__single">
                                <div class="healthy-food-one__content">
                                    <div class="healthy-food-one__icon"><span class="fas fa-broadcast-tower"></span></div>
                                    <p class="healthy-food-one__title">MQTT · telemetría, órdenes y confirmaciones</p>
                                </div>
                            </li>
                            <li class="healthy-food-one__single">
                                <div class="healthy-food-one__content">
                                    <div class="healthy-food-one__icon"><span class="fas fa-bolt"></span></div>
                                    <p class="healthy-food-one__title">WebSocket · eventos hacia la interfaz</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="counter-one section-space" id="modulos">
        <div class="counter-one__bg" style="background-image: url({{ asset('landing/assets/images/shapes/counter-one-shape-3-dark.png') }});"></div>
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Componentes del proyecto</span>
                <h2 class="section-title__title">Responsabilidades de la arquitectura</h2>
                <div class="section-title__icon">
                    <img src="{{ asset('landing/assets/images/icon/section-title-icon-1.png') }}" alt="icono">
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-3"><div class="metric-box"><h3>HTTP</h3><p>Administración y consultas</p></div></div>
                <div class="col-md-3"><div class="metric-box"><h3>MQTT</h3><p>Telemetría y órdenes</p></div></div>
                <div class="col-md-3"><div class="metric-box"><h3>WebSocket</h3><p>Eventos para la interfaz</p></div></div>
                <div class="col-md-3"><div class="metric-box"><h3>ESP32</h3><p>Prototipo de monitoreo y control</p></div></div>
            </div>
        </div>
    </section>

    <section class="project-one section-space" id="beneficios">
        <div class="project-one__bg float-bob-y-2" style="background-image: url({{ asset('landing/assets/images/shapes/project-one-shape-1.png') }});"></div>
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Criterios de evaluación</span>
                <h2 class="section-title__title">Indicadores para evaluar la comunicación IoT</h2>
                <div class="section-title__icon">
                    <img src="{{ asset('landing/assets/images/icon/section-title-icon-1.png') }}" alt="icono">
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="project-one__single">
                        <div class="project-one__inner">
                            <div class="project-one__img"><img src="{{ asset('landing/assets/images/project/project-one-1.jpg') }}" alt="Medición de tiempos de respuesta"></div>
                            <div class="project-one__content">
                                <span class="project-one__tagline">Técnico</span>
                                <h3 class="project-one__title">Oportunidad en la visualización y la confirmación</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="project-one__single">
                        <div class="project-one__inner">
                            <div class="project-one__img"><img src="{{ asset('landing/assets/images/project/project-one-2.jpg') }}" alt="Correspondencia entre lecturas y estados"></div>
                            <div class="project-one__content">
                                <span class="project-one__tagline">Operativo</span>
                                <h3 class="project-one__title">Consistencia entre el dispositivo, el servidor y la web</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="300ms">
                    <div class="project-one__single">
                        <div class="project-one__inner">
                            <div class="project-one__img"><img src="{{ asset('landing/assets/images/project/project-one-3.jpg') }}" alt="Seguimiento de mensajes y confirmaciones"></div>
                            <div class="project-one__content">
                                <span class="project-one__tagline">Diseño</span>
                                <h3 class="project-one__title">Entrega de eventos y órdenes confirmadas</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="400ms">
                    <div class="project-one__single">
                        <div class="project-one__inner">
                            <div class="project-one__img"><img src="{{ asset('landing/assets/images/project/project-one-4.jpg') }}" alt="Reconexión y sincronización del estado"></div>
                            <div class="project-one__content">
                                <span class="project-one__tagline">Impacto</span>
                                <h3 class="project-one__title">Recuperación de la comunicación ante interrupciones</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-one" id="contacto">
        <div class="cta-one__bg" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url({{ asset('landing/assets/images/backgrounds/cta-one-bg.jpg') }});"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="cta-one__inner">
                        <div class="cta-one__left">
                            <div class="cta-one__icon"><span class="icon-agriculture-2"></span></div>
                            <h3 class="cta-one__title">Arquitectura híbrida de comunicación web y telemetría para gestionar dispositivos IoT, órdenes y eventos.</h3>
                        </div>
                        <div class="cta-one__right">
                            <a href=" " class="thm-btn cta-one__btn">Acceder al sistema <i class="icon-right-arrow"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="site-footer__top">
            <div class="container">
                <div class="site-footer__top-inner">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="footer-widget__column footer-widget__about">
                                <div class="footer-widget__logo">
                                    <a href="#inicio"><img src="{{ asset('landing/assets/images/resources/footer-logo.png') }}" alt="MecaCuy"></a>
                                </div>
                                <div class="footer-widget__about-text-box">
                                    <p class="footer-widget__about-text">La tesis presenta una arquitectura híbrida que coordina la comunicación entre dispositivos IoT, servicios de aplicación e interfaz web.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="footer-widget__column footer-widget__Explore">
                                <div class="footer-widget__title-box"><h3 class="footer-widget__title">Secciones</h3></div>
                                <ul class="footer-widget__Explore-list list-unstyled">
                                    <li><a href="#proyecto">Proyecto</a></li>
                                    <li><a href="#problema">Desafíos</a></li>
                                    <li><a href="#arquitectura">Arquitectura IoT</a></li>
                                    <li><a href="#modulos">Módulos</a></li>
                                    <li><a href="#beneficios">Evaluación</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-12 col-md-12">
                            <div class="footer-widget__column footer-widget__Contact">
                                <div class="footer-widget__title-box"><h3 class="footer-widget__title">Datos del proyecto</h3></div>
                                <ul class="footer-widget__Contact-list list-unstyled">
                                    <li>
                                        <div class="icon"><span class="fas fa-user-graduate"></span></div>
                                        <div class="text"><p>Postulante</p><h5>Univ. Janneth Choque Quispe</h5></div>
                                    </li>
                                    <li>
                                        <div class="icon"><span class="fas fa-chalkboard-teacher"></span></div>
                                        <div class="text"><p>Tutora metodológica</p><h5>M. Sc. Zara Yujra Cama</h5></div>
                                    </li>
                                    <li>
                                        <div class="icon"><span class="fas fa-university"></span></div>
                                        <div class="text"><p>Tutor especialista</p><h5>M. Sc. Lic. Ing. Rodolfo Freddy Velásquez Arando</h5></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-footer__bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="site-footer__bottom-inner">
                            <p class="site-footer__bottom-text">© {{ date('Y') }} UPEA · Tesis de grado</p>
                            <div class="site-footer__bottom-scroll">
                                <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="icon-up-arrow"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>
        <div class="logo-box">
            <a href="#inicio" aria-label="logo image"><img src="{{ asset('landing/assets/images/resources/logo-2.png') }}" width="122" alt="MecaCuy" /></a>
        </div>
        <div class="mobile-nav__container"></div>
    </div>
</div>

<script src="{{ asset('landing/assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/jarallax/jarallax.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/jquery-appear/jquery.appear.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/odometer/odometer.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/swiper/swiper.min.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/wow/wow.js') }}"></script>
<script src="{{ asset('landing/assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('landing/assets/js/agrion.js') }}"></script>
</body>
</html>
