<template>
	<form
		class="w-[600px] bg-amber-500 m-2 p-2"
		@submit.prevent="onValidate"
	>
		<div class="flex justify-between">
			<AppFormInput
				id="anrede"
				v-model="form.anrede"
				label="Anrede"
				name="anrede"
				required
			/>
		</div>
		<div class="flex justify-between">
			<label for="firma">Firma</label>
			<input
				id="firma"
				v-model="form.firma"
				type="text"
				name="firma"
			>
		</div>
		<div class="flex justify-between">
			<div>
				<label for="vorname">Vorname</label>
				<span aria-hidden="true">*</span>
			</div>
			<input
				id="vorname"
				v-model="form.vorname"
				type="text"
				name="vorname"
				required
			>
			<div>
				<label for="nachname">Nachname</label>
				<span aria-hidden="true">*</span>
			</div>
			<input
				id="nachname"
				v-model="form.nachname"
				type="text"
				name="nachname"
				required
			>
		</div>
		<div class="flex justify-between">
			<div>
				<label for="e-mail">E-Mail</label>
				<span aria-hidden="true">*</span>
			</div>
			<input
				id="e-mail"
				v-model="form.email"
				type="email"
				name="e-mail"
				required
			>
		</div>
		<div class="hidden">
			<label for="password">Password</label>
			<input
				id="password"
				v-model="form.password"
				type="password"
				name="password"
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
				Sie in unseren <NuxtLink :to="{ name: 'footer-datensschutz', hash: '#10_kontaktformulare' }">
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
	password: string;
	dsvgo: boolean;
}

const form = reactive<FormData>({
	anrede: "",
	firma: "",
	vorname: "",
	nachname: "",
	email: "",
	password: "",
	dsvgo: false,
});

function onValidate() {
	if (form.password == null || form.password == "") {
		console.log("Form values:", form);
	}
	else {
		console.log("Honypot");
	}
}
</script>

<style></style>
