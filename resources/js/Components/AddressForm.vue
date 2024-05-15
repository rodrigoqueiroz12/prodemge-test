<script setup lang="ts">
import { Address } from '@/@types/address';
import axios from 'axios';
import { reactive, ref } from 'vue';
import { z } from 'zod';

const emit = defineEmits(['submit'])

const { defaultForm } = defineProps<{
    defaultForm?: Address
}>()

const formSchema = z.object({
    type: z.enum(['residencial', 'comercial']),
    zip_code: z.string().length(9, 'Por favor, insira um CEP válido'),
    street: z.string().min(1, 'O campo rua é obrigatório'),
    number: z.string().min(1, 'O campo número é obrigatório'),
    complement: z.string().default(''),
    neighborhood: z.string().min(1, 'O campo bairro é obrigatório'),
    state: z.string().min(1, 'O campo estado é obrigatório'),
    city: z.string().min(1, 'O campo cidade é obrigatório'),
})

type formSchemaType = z.infer<typeof formSchema>

let errors = ref<z.ZodFormattedError<formSchemaType> | null>()

const form = reactive({
    type: defaultForm?.type ?? 'residencial',
    zip_code: defaultForm?.zip_code ?? '',
    street: defaultForm?.street ?? '',
    number: defaultForm?.number ?? '',
    complement: defaultForm?.complement ?? '',
    neighborhood: defaultForm?.neighborhood ?? '',
    state: defaultForm?.state ?? '',
    city: defaultForm?.city ?? '',
})

const searchedByZipCode = ref({
    street: '',
    neighborhood: '',
    state: '',
    city: '',
})

const addressTypes = [
    {
        title: 'Residencial',
        value: 'residencial',
    },
    {
        title: 'Comercial',
        value: 'comercial',
    }
]

function handleSubmit() {
    const validSchema = formSchema.safeParse(form)

    if (!validSchema.success) {
        errors.value = validSchema.error.format()

        return
    }

    errors.value = null

    emit('submit', form)
}

async function handleSearchZipCode() {
    if (form.zip_code.length !== 8) {
        return
    }

    const zipCode = form.zip_code.replace('-', '')

    const res = await axios.get(`https://viacep.com.br/ws/${zipCode}/json/`)

    searchedByZipCode.value.city = res.data.localidade
    searchedByZipCode.value.neighborhood = res.data.bairro
    searchedByZipCode.value.state = res.data.uf
    searchedByZipCode.value.street = res.data.logradouro

    form.city = res.data.localidade
    form.neighborhood = res.data.bairro
    form.state = res.data.uf
    form.street = res.data.logradouro
}

function formatZipCode() {
    let zipCode = form.zip_code.replace(/\D/g, '');

    if (zipCode.length > 8) {
        zipCode = zipCode.substring(0, 9);
    }

    zipCode = zipCode.replace(/^(\d{5})(\d{3})$/, '$1-$2');

    form.zip_code = zipCode
}

</script>

<template>
    <form id="store-address-form" @submit.prevent="handleSubmit">
        <v-row dense>
            <v-col cols="4">
                <v-select label="Tipo" :items="addressTypes" v-model="form.type" variant="outlined" :error-messages="errors?.type?._errors"></v-select>
            </v-col>

            <v-col cols="8">
                <v-text-field label="CEP" v-model="form.zip_code" @input="handleSearchZipCode" @keyup="formatZipCode" variant="outlined" :error-messages="errors?.zip_code?._errors" />
            </v-col>

            <v-col cols="4">
                <v-text-field label="Número" v-model="form.number" variant="outlined" :error-messages="errors?.number?._errors" />
            </v-col>

            <v-col cols="8">
                <v-text-field label="Rua" v-model="form.street" :disabled="!!searchedByZipCode.street" variant="outlined" :error-messages="errors?.street?._errors" />
            </v-col>

            <v-col cols="12">
                <v-text-field label="Bairro" v-model="form.neighborhood" :disabled="!!searchedByZipCode.neighborhood" variant="outlined" :error-messages="errors?.neighborhood?._errors" />
            </v-col>

            <v-col cols="8">
                <v-text-field label="Cidade" type="text" v-model="form.city" :disabled="!!searchedByZipCode.city" variant="outlined" :error-messages="errors?.city?._errors" />
            </v-col>

            <v-col cols="4">
                <v-text-field label="Estado" type="text" v-model="form.state" :disabled="!!searchedByZipCode.state" variant="outlined" :error-messages="errors?.state?._errors" />
            </v-col>

            <v-col cols="12">
                <v-text-field label="Complemento (opcional)" v-model="form.complement" variant="outlined" />
            </v-col>
        </v-row>
    </form>
</template>
