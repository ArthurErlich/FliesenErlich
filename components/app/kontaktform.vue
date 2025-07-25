<template>
	<div>
		<h1>Kontakt</h1>
		<form
			class="contact"
			@submit.prevent="onValidate"
		>
			<div class="input-pair">
				<AppFormInput
					id="anrede"
					v-model="form.anrede"
					label="Anrede"
					name="anrede"
					type="input"
					required
				/>
				<AppFormInput
					id="firma"
					v-model="form.firma"
					label="Firma"
					type="input"
				/>
			</div>
			<div class="input-pair">
				<AppFormInput
					id="vorname"
					v-model="form.vorname"
					label="Vorname"
					type="input"
					required
				/>
				<AppFormInput
					id="nachname"
					v-model="form.nachname"
					label="Nachname"
					type="input"
					required
				/>
			</div>
			<div class="input-pair">
				<AppFormInput
					id="email"
					v-model="form.email"
					label="E-Mail"
					type="email"
					required
				/>
				<div class="input-form" />
			</div>
			<hr class="line">
			<label for="nachricht">Nachricht</label>
			<textarea
				id="nachricht"
				v-model="form.nachname"
				class="textarea"
				name="nachricht"
				maxlength="10000"
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
			<div class="dsvgo-check">
				<input
					id="dsvgo"
					type="checkbox"
					name="dsvgo"
					required
				>
				<label for="dsvgo">Wir verwenden Ihre Angaben zur Beantwortung Ihrer Anfrage. Weitere Informationen
					finden
					Sie in unseren <NuxtLink :to="{ name: 'footer-datenschutz', hash: '#10_kontaktformulare' }">
						Datenschutzhinweisen</NuxtLink>.</label>
			</div>
			<div class="submit-wrapper">
				<button
					type="submit"
					class="submit-button"
				>
					Anfrage Senden
				</button>
			</div>
		</form>
	</div>
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
.contact {
	margin: 5px;
	padding: 5px;
}

textarea {
	width: 100%;
	min-height: 200px;
	resize: none;
	outline: none;
	border-radius: 1px;
	border: 1px solid black;
}

.input-pair {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
}

.input-pair>* {
	width: 40%;
}

@media (min-width: 360px) {
	.input-pair {
	justify-content: center;
}
	.input-pair>* {
		width: 300px;
	}
}

.dsvgo-check {
	display: flex;
}

.input-element {
	width: 100%;
	outline: none;
	border-radius: 1px;
	border: 1px solid black;
}

.submit-wrapper {
	display: flex;
	justify-content: center;
}

.submit-button {
	padding: 10px;
	border: none;
	outline: none;
	border-radius: 1px;
	background-color: var(--erlich-default);
	color: var(--erlich-white);
	/* rounded-md bg-erlich hover:bg-erlich-light */
}

.submit-button:hover {
	background-color: var(--erlich-light);

}
</style>
