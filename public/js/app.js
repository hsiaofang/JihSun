function showDetails(id) {
    const detailsRow = document.getElementById(`details-row${id}`);

    if (!detailsRow) {
        return;
    }

    if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
        detailsRow.style.display = 'table-row';
    } else {
        detailsRow.style.display = 'none';
    }
}




function toggleDetails(name) {

    const detailsPanel = document.getElementById('details-' + name);

    if (detailsPanel) {
        if (detailsPanel.style.display === 'none' || detailsPanel.style.display === '') {
            detailsPanel.style.display = 'table-row';
        } else {
            detailsPanel.style.display = 'none';
            console.log('Hiding details for:', name);  
        }
    } else {
        console.error('Details panel not found for name:', name);
    }
}



