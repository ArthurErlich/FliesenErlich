<template>
	<div>
		<div class="flex justify-between">
			<div>
				<label :for="id">{{ label }}</label>
				<span
					v-if="required"
					aria-hidden="true"
				>*</span>
			</div>
			<input
				:id="id"
				:v-model="modelValue"
				:type="type"
				:name="id"
				:required="required"
				class="input-element"
				@input="$emit('update:modelValue', $event.target.value)"
			>
		</div>
	</div>
</template>

<script>
export default {
	name: "FormInput",
	props: {
		modelValue: {
			type: String,
			default: "",
		},
		id: {
			type: String,
			required: true,
		},
		label: {
			type: String,
			required: true,
		},
		type: {
			type: String,
			default: "text",
		},
		// name: {
		// 	type: String,
		// 	required: true,
		// },
		required: {
			type: Boolean,
			default: false,
		},
	},
	emits: ["update:modelValue"],
};
</script>
