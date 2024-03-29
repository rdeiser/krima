document.addEventListener('DOMContentLoaded',()=>{
	const useBoth = true;
    const barcode_elt = document.getElementById('barcode');
    const enumeration_a_elt = document.getElementById('enumeration_a');
    const enumeration_b_elt = document.getElementById('enumeration_b');
    const chronology_i_elt = document.getElementById('chronology_i');
    const chronology_j_elt = document.getElementById('chronology_j');
	const copy_id_elt = document.getElementById('copy_id');
    const description_elt = document.getElementById('description');
    const onUse = function(e) {
        barcode_elt.classList.remove("znew");
    }
    const onUpdate = function(e) {
        const enumeration_a = enumeration_a_elt.value;
        const enumeration_b = enumeration_b_elt.value;
		const enumeration = ( enumeration_a ? enumeration_a +
			( useBoth && enumeration_b ? ':' + enumeration_b : '') : '' );
        const chronology_i = chronology_i_elt.value;
        const chronology_j = chronology_j_elt.value;
		const chronology = ( chronology_i ? '(' + chronology_i + 
			( useBoth && chronology_j ? ':' + chronology_j : '' ) + ')': '' );
        const copy_id = copy_id_elt.value;
		const description = enumeration + ' ' + chronology;
        description_elt.value = description;
    };
    enumeration_a_elt.addEventListener('input',onUpdate);
    enumeration_b_elt.addEventListener('input',onUpdate);
    chronology_i_elt.addEventListener('input',onUpdate);
    chronology_j_elt.addEventListener('input',onUpdate);
	copy_id_elt.addEventListener('input',onUpdate);
    barcode_elt.addEventListener('input',onUse);
    barcode_elt.addEventListener('click',onUse);
    barcode_elt.addEventListener('focus',onUse);
});