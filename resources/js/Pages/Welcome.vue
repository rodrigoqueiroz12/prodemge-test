<script setup lang="ts">
import { reactive, ref } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { format } from 'date-fns'
import PersonFrom from '@/Components/PersonForm.vue';
import AddressForm from '@/Components/AddressForm.vue';

const { people } = defineProps<{
    canLogin: boolean,
    canRegister: boolean,
    laravelVersion: string,
    phpVersion: string,
    people: {
        public_id: string,
        name: string,
        document: string,
        email: string
    }[],
}>()

const dialog = ref(false)

const step = ref(1)

const items = [
    'Criar pessoa',
    'Criar endereço',
]

const newPersonData = reactive({
    person: {},

    address: {},
})

function handleSubmitPersonForm(data: any) {
    newPersonData.person = data

    step.value++
}

function handleSubmitAddressForm(data: any) {
    newPersonData.address = data

    router.post('/people', { ...newPersonData.person, ...newPersonData.address }, {
        preserveScroll: false,
    })

    newPersonData.person = {}
    newPersonData.address = {}

    dialog.value = false
    step.value = 1
}

function handleVisitPerson(url: string) {
    router.visit(url)
}

const headers = [
    { title: 'Nome', value: 'name', key: 'name' },
    { title: 'Telefone', value: 'phone', key: 'phone' },
    { title: 'E-mail', value: 'email', key: 'email' },
    { title: 'CPF', value: 'document', key: 'document' },
    {
        title: 'Adicionado em',
        value: (item: any) => format(new Date(item.created_at), "dd/MM/yyyy 'às' H:ii"),
        key: 'created_at',
        sortable: false,
    },
    {
        title: 'Ações', key: 'actions', sortable: false
    }
]
</script>

<template>
    <guest-layout>

        <Head title="Pessoas" />

        <v-container class="mt-12">
            <v-row>
                <h2>Pessoas</h2>
            </v-row>

            <v-row>
                <v-col cols="2" class="d-flex justify-end">
                    <v-dialog v-model="dialog" max-width="600">
                        <template v-slot:activator>
                            <v-btn prepend-icon="mdi-plus" class="" @click="dialog = true">Adicionar</v-btn>
                        </template>

                        <v-stepper v-model="step" :items="items" class="mx-4" hide-actions>
                            <template v-slot:item.1>
                                <v-card>
                                    <v-card-text>
                                        <PersonFrom @submit="handleSubmitPersonForm" />
                                    </v-card-text>
                                </v-card>
                            </template>

                            <template v-slot:item.2>
                                <v-card>
                                    <v-card-text>
                                        <AddressForm @submit="handleSubmitAddressForm" />
                                    </v-card-text>
                                </v-card>
                            </template>

                            <v-stepper-actions>
                                <template v-slot:next>
                                    <v-btn type="submit" :form="step === 2 ? 'store-address-form' : 'store-person-form'" v-text="step === 2 ? 'Criar' : 'Próximo'" :disabled="false"></v-btn>
                                </template>

                                <template v-slot:prev>
                                    <v-btn @click="step = step - 1">Voltar</v-btn>
                                </template>
                            </v-stepper-actions>
                        </v-stepper>
                    </v-dialog>
                </v-col>

                <v-col>
                    <v-data-table v-if="people.length > 0" :items="people" :headers="headers" no-data-text="Nenhuma pessoa encontrada">
                        <template v-slot:item.actions="{ item }">
                            <v-btn @click="handleVisitPerson($route('people.show', item.public_id))" density="comfortable" icon="mdi-account-details" variant="tonal"></v-btn>
                        </template>
                    </v-data-table>

                    <div v-else class="d-flex justify-center my-12">
                        Ainda não há nenhuma pessoa cadastrada
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </guest-layout>
</template>
