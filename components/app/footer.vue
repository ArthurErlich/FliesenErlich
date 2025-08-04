<template>
	<footer
		ref="root"
		class=""
	>
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
		<div class="footer-gap" />
		<div class="container footer-wraper company">
			<div class="company-adress">
				Mobile: <a href="tel:01634310646 ">01634310646 </a> <br>
				Telefon: <a href="tel:077749394447">07774 93 94 447</a> <br>
				E-Mail: <a href="mailto:fliesenerlich@hotmail.com">fliesenerlich@hotmail.com</a>
			</div>
			<div class="company-adress">
				Waldemar Erlich <br>
				Obere Blatt 17<br>
				78253 Eigeltingen
			</div>
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
	display: flex;
	justify-content: center;
	margin: auto;
}

footer {
	background-color: var(--erlich-default);
}
.company-adress{
	text-align: left;
	vertical-align: baseline;
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
	align-items: center;
	flex-wrap: wrap;
	justify-content: space-evenly;
	color: var(--erlich-white);
	gap: 10px
}
.footer-gap{
	height:25px;
	background-color: var(--erlich-white);
	background-image: var(--erlich-svg-fill);
	background-size:contain;
	background-position: 5px 5px;
	border-top-left-radius: 50px;
	border-bottom-right-radius: 50px;
	margin-left:20px;
	margin-right:20px;
	/* margin-top: 10px; */
	margin-bottom: 10px;
}
@media (max-width: 767px) {
	.footer-wraper > ul{
		flex-direction: column;
		gap: 5px;
	}
	.company{
		flex-direction: column;
		gap: 5px;
	}
	.company > *{
		width: 250px
	}

}
</style>
