<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Person } from '@/@types/person';
import PersonForm from '@/Components/PersonForm.vue';
import AddressForm from '@/Components/AddressForm.vue';
import { Address } from '@/@types/address';
import { ref } from 'vue';
import { format } from 'date-fns';

const { person } = defineProps<{
    person: Person,
}>()

function handleUpdatePerson(data: Person) {
    router.put(`/people/${person.public_id}`, data)
}

function handleUpdateAddress(data: Address) {
    router.put(`/addresses/${person.addresses[0].id}`, data)
}

const historyDialog = ref(false)
</script>

<template>
    <guest-layout>

        <Head :title="person.name" />

        <v-container class="my-12">
            <v-btn class="mb-6" variant="text" prepend-icon="mdi-arrow-left" @click="router.visit('/')">
                Voltar
            </v-btn>

            <h1 v-text="person.name" class="mb-12"></h1>

            <v-row>
                <v-col class="d-flex justify-end">
                    <v-dialog v-model="historyDialog" max-width="992">
                        <template v-slot:activator>
                            <v-btn @click="historyDialog = true">Histórico de endereços</v-btn>
                        </template>

                        <v-card>
                            <v-table height="80vh" fixed-header>
                                <thead>
                                    <tr>
                                        <th class="text-left">
                                            ID
                                        </th>
                                        <th class="text-left">
                                            Tipo
                                        </th>
                                        <th class="text-left">
                                            CEP
                                        </th>
                                        <th class="text-left">
                                            Rua
                                        </th>
                                        <th>
                                            Número
                                        </th>
                                        <th>
                                            Bairro
                                        </th>
                                        <th>
                                            Estado
                                        </th>
                                        <th>Complemento</th>
                                        <th>Adicionado em</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="address in person.addresses">
                                        <td v-text="address.id"></td>
                                        <td v-text="address.type.charAt(0).toUpperCase() + address.type.substring(1)"></td>
                                        <td v-text="address.zip_code"></td>
                                        <td v-text="address.street"></td>
                                        <td v-text="address.number"></td>
                                        <td v-text="address.neighborhood"></td>
                                        <td v-text="address.state"></td>
                                        <td v-text="address.complement ?? '-'"></td>
                                        <td v-text="format(new Date(address.created_at), `dd/MM/yyyy 'às' H:ii`)"></td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </v-dialog>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="6">
                    <div class="d-flex flex-column">
                        <PersonForm :default-form="person" @submit="handleUpdatePerson" />

                        <v-btn type="submit" form="store-person-form" class="mt-4" variant="tonal">Atualizar</v-btn>
                    </div>
                </v-col>

                <v-col cols="6">
                    <div class="d-flex flex-column">
                        <AddressForm :default-form="person.addresses[0]" @submit="handleUpdateAddress" />

                        <v-btn type="submit" form="store-address-form" class="mt-4" variant="tonal">Atualizar</v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </guest-layout>
</template>
