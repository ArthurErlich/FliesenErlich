// Shared client-side validation behavior for any <form> built from
// src/components/form/*. Red bottom border + error text once a field is
// genuinely invalid: either the user typed something invalid, or they tried
// to submit. Merely tabbing past an untouched empty required field must NOT
// flag it — that reads as a stuck/broken focus indicator, not a real error.
export function wireFormValidation(form: HTMLFormElement) {
	let submitted = false;
	const fields = form.querySelectorAll<
		HTMLInputElement | HTMLTextAreaElement
	>(
		'input[required]:not([type="checkbox"]), textarea[required], input[type="email"]',
	);

	function setInvalid(
		el: HTMLInputElement | HTMLTextAreaElement,
		invalid: boolean,
	) {
		el.style.borderBottomColor = invalid ? 'var(--color-default)' : '';
		el.style.borderBottomWidth = invalid ? '2px' : '';
		el.setAttribute('aria-invalid', invalid ? 'true' : 'false');
		const err = document.getElementById(
			el.getAttribute('aria-describedby')?.split(' ').pop() ?? '',
		);
		err?.classList.toggle('hidden', !invalid);
	}

	fields.forEach((el) => {
		el.addEventListener('blur', () => {
			if (el.value.length > 0 || submitted)
				setInvalid(el, !el.checkValidity());
		});
		el.addEventListener('input', () => setInvalid(el, !el.checkValidity()));
	});

	return {
		/** Call from the form's submit handler before doing anything else. Returns false if the form should not submit. */
		validateOnSubmit(): boolean {
			submitted = true;
			fields.forEach((el) => setInvalid(el, !el.checkValidity()));
			return form.checkValidity();
		},
	};
}
