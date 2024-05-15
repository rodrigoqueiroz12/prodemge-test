<script setup lang="ts">
import AppLayout from './AppLayout.vue'
</script>

<template>
    <app-layout>
        <v-layout>
            <v-app-bar :elevation="2">
                <v-app-bar-title>Prodemge</v-app-bar-title>
            </v-app-bar>

            <v-main>
                <slot />
            </v-main>
        </v-layout>
    </app-layout>
</template>
