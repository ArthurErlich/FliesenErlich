<template>
	<section class="container">
		<h1>Kontakt</h1>

		<div v-if="!isHidden">
			<AppKontaktform />
		</div>
		<AppMap />
	</section>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const isHidden = ref(true);
</script>

<style scoped>

</style>
