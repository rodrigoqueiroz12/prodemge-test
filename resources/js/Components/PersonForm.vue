<script setup lang="ts">
import z from 'zod';

import { reactive, ref } from 'vue';

const emit = defineEmits(['submit'])

const { defaultForm } = defineProps<{
    defaultForm?: {
        name: string
        alternate_name: string
        document: string
        father_name: string
        mother_name: string
        phone: string
        email: string
    }
}>()

const formSchema = z.object({
    name: z.string().min(3, 'O campo nome precisa de no mínimo 3 caracteres').max(255, 'O campo nome pode ter no máximo 255 caracteres'),
    alternate_name: z.string().min(3, 'O campo nome social precisa de no mínimo 3 caracteres').max(255, 'O campo nome social pode ter no máximo 255 caracteres'),
    document: z.string().length(14, 'Por favor, insira um CPF válido'),
    father_name: z.string().default(''),
    mother_name: z.string().default(''),
    phone: z.string().length(16, 'Por favor, insira um telefone válido'),
    email: z.string().email('Por favor, insira um e-mail válido'),
})

type formSchemaType = z.infer<typeof formSchema>

const errors = ref<z.ZodFormattedError<formSchemaType>>()

const form = reactive({
    name: defaultForm?.name ?? '',
    alternate_name: defaultForm?.alternate_name ?? '',
    document: defaultForm?.document ?? '',
    father_name: defaultForm?.father_name ?? '',
    mother_name: defaultForm?.mother_name ?? '',
    phone: defaultForm?.phone ?? '',
    email: defaultForm?.email ?? '',
})

function handleSubmit() {
    const validSchema = formSchema.safeParse(form)

    if (!validSchema.success) {
        errors.value = validSchema.error.format()

        return
    }

    emit('submit', form)
}

function formatPhone() {
    let phone = form.phone.replace(/\D/g, '');

    if (phone.length <= 11) {
        phone = phone.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})$/, '($1) $2 $3-$4');
    } else {
        phone = phone.substring(0, 11); // Limita a string a 11 dígitos
        phone = phone.replace(/^(\d{2})(\d{1})(\d{4})(\d{4})$/, '($1) $2 $3-$4');
    }

    form.phone = phone;
}

function formatDocument() {
    let cpf = form.document.replace(/\D/g, '');

    if (cpf.length > 11) {
        cpf = cpf.substring(0, 11);
    }

    if (cpf.length > 3) {
        cpf = cpf.replace(/^(\d{3})(\d)/, '$1.$2');
    }
    if (cpf.length > 6) {
        cpf = cpf.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
    }
    if (cpf.length > 9) {
        cpf = cpf.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d{2})$/, '$1.$2.$3-$4');
    }

    form.document = cpf;
}
</script>

<template>
    <form id="store-person-form" @submit.prevent="handleSubmit">
        <v-row dense>
            <v-col cols="12" lg="6">
                <v-text-field label="Nome completo" v-model="form.name" variant="outlined" :error-messages="errors?.name?._errors"></v-text-field>
            </v-col>

            <v-col cols="12" lg="6">
                <v-text-field label="Nome social" v-model="form.alternate_name" variant="outlined" :error-messages="errors?.alternate_name?._errors"></v-text-field>
            </v-col>

            <v-col cols="12">
                <v-text-field label="Nome do pai (opcional)" v-model="form.father_name" variant="outlined"></v-text-field>
            </v-col>

            <v-col cols="12">
                <v-text-field label="Nome da mãe (opcional)" v-model="form.mother_name" variant="outlined"></v-text-field>
            </v-col>

            <v-col cols="12" sm="6">
                <v-text-field label="CPF" v-model="form.document" placeholder="123.456.789-10" variant="outlined" @input="formatDocument" :error-messages="errors?.document?._errors"></v-text-field>
            </v-col>

            <v-col cols="12" sm="6">
                <v-text-field label="Telefone" v-model="form.phone" variant="outlined" @input="formatPhone" :error-messages="errors?.phone?._errors"></v-text-field>
            </v-col>

            <v-col cols="12">
                <v-text-field label="E-mail" type="email" v-model="form.email" variant="outlined" :error-messages="errors?.email?._errors"></v-text-field>
            </v-col>
        </v-row>
    </form>
</template>
