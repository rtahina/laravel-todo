<script setup>
    import rocket from '@/images/loader.gif';
</script>

<template>
    <div class="loader">
        <span>
            <img :src="rocket" alt="Loading" width="50px" height="auto" />
        </span>
    </div>
</template>

<style scoped>
    .loader {
        position: absolute;
        left:0;
        right: 0;
        bottom:0;
        top: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 3;
        
        span {
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.3);
            width: 100px;
            height: 100px;
            border-radius: 1em;
        }
    }
</style>