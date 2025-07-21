<template>
	<footer
		ref="root"
		class=""
	>
		<div class="container footer-wraper company">
			<div>
				Mobile: <a href="tel:01634310646 ">01634310646 </a> <br>
				Telefon: <a href="tel:077749394447">07774 93 94 447</a> <br>
				E-Mail: <a href="mailto:fliesenerlich@hotmail.com">fliesenerlich@hotmail.com</a>
			</div>
			<div>
				Adresse <br>
				Adresse
			</div>
		</div>
		<div class="container footer-wraper">
			<ul>
				<li>
					<NuxtLink :to="{ name: 'kontakt' }">Kontakt</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-impressum' }">Impressum</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-datenschutz' }">Datenschutz</NuxtLink>
				</li>
				<li>
					<NuxtLink :to="{ name: 'footer-cookies' }">Cookies</NuxtLink>
				</li>
			</ul>
		</div>
	</footer>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const root = ref<HTMLElement | null>(null);

// This makes the DOM ref accessible to the parent
defineExpose({
	el: root,
});
</script>

<style scoped>
.footer-wraper {
	padding: 5px;
}

.footer-wrapper {
	height: 50px;
	display: flex;
	justify-content: baseline;
	margin: auto;
}

footer {
	background-color: var(--erlich-default);
}

ul {
	width: 100%;
	list-style: none;
	align-items: center;
	justify-content: space-between;
	gap: 5px;
	display: flex;
	padding: 0;
}

li {
	display: inline;
	margin: 0;
}

a {
	color: var(--erlich-white);
	text-decoration: none;
}

a:hover {
	color: var(--erlich-white);

}
.company{
	display: flex;
	align-items: baseline;
	justify-content: space-evenly;
	color: var(--erlich-white)
}
</style>
