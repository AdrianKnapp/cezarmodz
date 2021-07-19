const filterCheckbox = document.querySelectorAll('.dropdown-checkbox');

filterCheckbox.forEach((checkbox, index) => checkbox.addEventListener('change', () => blockOtherCheckboxes(checkbox.classList[1], index)));

function blockOtherCheckboxes(inputClass, index) {
	const checkboxGroupToBlock = document.querySelectorAll('.' + inputClass);
	const checkboxHidden = document.getElementsByClassName('js-' + inputClass)[0];

	if (filterCheckbox[index].checked) {
		checkboxGroupToBlock.forEach((checkbox) => checkbox.checked = false);
		filterCheckbox[index].checked = true;
		checkboxHidden.checked = false;
	} else {
		checkboxHidden.checked = true;
	}
}
