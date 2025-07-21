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
					required-back
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
					required-back
				/>
				<AppFormInput
					id="nachname"
					v-model="form.nachname"
					label="Nachname"
					type="input"
					required-back
				/>
			</div>
			<div class="input-pair">
				<AppFormInput
					id="email"
					v-model="form.email"
					label="E-Mail"
					type="email"
					required-back
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
					requiredBack
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
		fetch("/server/api/v1/sendMail", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				postTitle: "sendMail",
				postAuthor: "nuxt-app",
			}),
		})
			.then(
				// hide contact form and display send success msg
			)
			.catch(
				// throw an error to the page
			);
	}
	else {
		console.log("Honypot");
		// block this ip for 24 houres
		fetch("/server/api/v1/getClinetIP", {
			method: "GET",
		})
			.then(
			// block the ip adress
			)
			.catch(
			// log that this ip adress cannot be blocke or none was found etc?
			);
		console.log("Your IP:");
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
	justify-content: space-between;
}

.dsvgo-check {
	display: flex;
}

.input-element {
	width: 300px;
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
