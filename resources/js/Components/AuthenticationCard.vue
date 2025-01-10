<template>
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center px-6 pt-6 sm:pt-0 overflow-hidden">
        <!-- Contenedor de olas -->
        <div class="waves">
            <div class="wave a"></div>
            <div class="wave b"></div>
            <div class="wave c"></div>
        </div>

        <!-- Contenido principal -->
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-xl z-10">
            <slot />
        </div>
    </div>
</template>

<style scoped>
body {
    margin: 0;

    background: rgb(213,254,255);
    background: linear-gradient(0deg, rgba(213,254,255,1) 0%, rgba(34,193,195,1) 34%, rgba(24,50,73,1) 79%, rgba(6,20,26,1) 100%);
}

.relative {
    position: relative;
    background: rgb(213,254,255);
    background: linear-gradient(0deg, rgba(213,254,255,1) 0%, rgba(34,193,195,1) 34%, rgba(24,50,73,1) 79%, rgba(6,20,26,1) 100%);
    overflow: hidden;
}

/* Configuración de las olas */
.waves {
    position: absolute;
    bottom: -135px;
    height: 527px;
    width: 100%;
    overflow: hidden;
    z-index: 0;
}

.wave {
    position: absolute;
    left: -180px;
    bottom: 0;
    width: 2402px;
    height: 427px;
    background: url(https://static.platzi.com/media/files/waves_c8551f5d-ecf6-4a81-ae1d-f3a0ad55ba10.png) center bottom no-repeat;
    animation: wave 5s ease-in-out infinite alternate;
}

.wave.a {
    background-position: 0 -854px;
}

.wave.b {
    background-position: 0 -427px;
    animation-delay: 0.6s;
}

.wave.c {
    background-position: 0 0;
    animation-delay: 1.2s;
}

/* Animación de las olas */
@keyframes wave {
    0% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(-80px, 30px);
    }
    100% {
        transform: translate(160px, -60px);
    }
}

/* Contenedor principal */
.z-10 {
    position: relative;
    z-index: 10;
}
</style>

