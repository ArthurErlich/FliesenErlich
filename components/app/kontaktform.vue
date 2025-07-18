<template>
	<form
		class=" m-2 p-2"
		@submit.prevent="onValidate"
	>
		<div class="flex justify-around">
			<AppFormInput
				id="anrede"
				v-model="form.anrede"
				class="w-[300px]"
				label="Anrede"
				name="anrede"
				type="input"
				required
			/>
			<AppFormInput
				id="firma"
				v-model="form.firma"
				class="w-[300px]"
				label="Firma"
				type="input"
			/>
		</div>
		<div class="flex justify-around">
			<AppFormInput
				id="vorname"
				v-model="form.vorname"
				class="w-[300px]"
				label="Vorname"
				type="input"
				required
			/>
			<AppFormInput
				id="nachname"
				v-model="form.nachname"
				class="w-[300px]"
				label="Nachname"
				type="input"
				required
			/>
		</div>
		<div class="flex justify-around">
			<AppFormInput
				id="email"
				v-model="form.email"
				class="w-[300px]"
				label="E-Mail"
				type="email"
				required
			/>
			<div class="w-[300px]" />
		</div>
		<hr class="mb-2 mt-2 border-1 border-red-900">
		<label for="nachricht">Nachricht</label>
		<textarea
			id="nachricht"
			v-model="form.nachname"
			class="w-[100%]"
			name="nachricht"
		/>
		<div class="isHuman">
			<label for="password">Password</label>
			<input
				id="password"
				v-model="form.password"
				type="text"
				name="password"
			>
		</div>
		<div class="isHuman">
			<label for="e-mail-confirm">Confirm E-Mail</label>
			<input
				id="e-mail-confirm"
				v-model="form.email_confirm"
				type="email"
				name="e-mail-confirm"
			>
		</div>
		<div>
			<input
				id="dsvgo"
				type="checkbox"
				name="dsvgo"
				required
			>
			<label for="dsvgo">Wir verwenden Ihre Angaben zur Beantwortung Ihrer Anfrage. Weitere Informationen finden
				Sie in unseren <NuxtLink :to="{ name: 'footer-datenschutz', hash: '#10_kontaktformulare' }">
					Datenschutzhinweisen</NuxtLink>.</label>
		</div>
		<div class="flex justify-center">
			<button
				type="submit"
				class="rounded-md bg-erlich hover:bg-erlich-light"
			>
				Anfrage Senden
			</button>
		</div>
	</form>
</template>

<script lang="ts" setup>
import { reactive } from "vue";

interface FormData {
	anrede: string;
	firma: string;
	vorname: string;
	nachname: string;
	email: string;
	email_confirm: string;
	password: string;
	dsvgo: boolean;
	nachricht: string;
}

const form = reactive<FormData>({
	anrede: "",
	firma: "",
	vorname: "",
	nachname: "",
	email: "",
	email_confirm: "",
	password: "",
	dsvgo: false,
	nachricht: "",
});

function onValidate() {
	if (form.password == "" || form.email_confirm) {
		console.log("Form values:", form);
	}
	else {
		console.log("Honypot");
	}
}
</script>

<style>
input,textarea{
	background-color: rgb(201, 201, 201);
	}
</style>
