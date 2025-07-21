<template>
	<div class="container mx-auto flex items-center flex-col">
		<AppKontaktform :class="{ hidden: isHidden }" />
		<AppMap />
	</div>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const isHidden = ref(true);
</script>

<style scoped>

</style>
