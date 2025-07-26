<template>
	<div class="container">
		<h1>Unsere Philosophie</h1>
		<h2>Historie</h2>
		<ul>
			<li>Gründung</li>
			<li>Lager mietung</li>
			<li>Aufnahme Azubi</li>
			<li>Ausbilderschein</li>
		</ul>
		<h2>Das Fliesen Erlich Team</h2>
		<div class="employees">
			<AppEmployee
				src="/media/employees/waldemar-erlich.jpg"
				name="Waldemar Erlich"
				moto="Leidenschaftlicher Angler und der richtige Ansprechpartner wenne es um Fliesen geht."
			/>
			<AppEmployee
				src="https://img.icons8.com/wired/64/small-smile.png"
				name="Benjamin Erlich"
				moto="Benji"
			/>
			<AppEmployee
				src="https://img.icons8.com/wired/64/small-smile.png"
				name="Azubi1"
				moto="Azubi"
			/>
		</div>
	</div>
</template>

<script lang="ts" setup>

</script>

<style>
.employees{
	display: flex;
	align-items: baseline;
	flex-wrap: wrap;
	justify-content: space-evenly;
}
</style>
