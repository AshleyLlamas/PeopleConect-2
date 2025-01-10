<template>
    <NavbarHome />
    <div class="relative min-h-screen w-full bg-surface-0">
        <!-- Video de fondo -->
        <video
            src="/media/mar.mp4"
            autoplay
            loop
            muted
            playsinline
            class="absolute top-0 left-0 w-full h-full object-cover">
        </video>

        <!-- Contenido centrado -->
        <div class="relative z-10 flex items-center justify-center h-full pt-24">
            <!-- Div blanco -->
            <div class="bg-teal-600 bg-opacity-90 rounded-full p-8 text-center shadow-xl max-w-lg">
                <img src="/img/logovivelabajaBlanco.png" alt="Logo" class="mx-auto h-68">
            </div>
        </div>
    </div>
</template>

<script setup>
    import NavbarHome from '../Components/NavbarHome.vue';
</script>

<style scoped>
/* Aseguramos que el video cubra todo el fondo */
video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -20;
}
</style>
