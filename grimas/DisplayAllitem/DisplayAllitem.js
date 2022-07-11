document.addEventListener('DOMContentLoaded',()=>{
	const inventory_date_elt = document.getElementByID('inventory_date');
	const onUpdate = function(e) {
		const inventory_date = inventory_date_elt.value;
	}
    inventory_date_elt.addEventListener('input',onUpdate);
});
