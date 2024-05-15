<script setup lang="ts">
import AppLayout from './AppLayout.vue'
</script>

<template>
    <app-layout>
        <v-layout>
            <v-app-bar :elevation="2">
                <template v-slot:prepend>
                    <v-app-bar-nav-icon></v-app-bar-nav-icon>
                </template>

                <v-app-bar-title>Prodemge</v-app-bar-title>
            </v-app-bar>

            <v-main>
                <slot />
            </v-main>
        </v-layout>
    </app-layout>
</template>
