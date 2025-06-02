function changeMainContent(element, type) {
    const mainImage = document.getElementById('mainImage');
    const mainVideo = document.getElementById('mainVideo');

    if (type === 'image') {
        mainImage.src = element.src;
        mainImage.style.display = 'block';
        mainVideo.style.display = 'none';
        mainVideo.pause();
    } else if (type === 'video') {
        mainVideo.src = element.src;
        mainVideo.style.display = 'block';
        mainImage.style.display = 'none';
        mainVideo.play();
    }
}

window.onload = function() {
    const defaultVideo = document.getElementById('defaultVideo');
    changeMainContent(defaultVideo, 'video');
};

function loadColors(materialID) {
    fetch('/getColorsByMaterial', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'topMaterialsID=' + materialID
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('colors').innerHTML = html;
            // After loading colors, enforce only one is selected
            enforceSingleSelection('colors', 'topLayerID');
        });
}

function selectTopMaterial(selectedElement) {
    const container = document.getElementById('topMaterials');
    const items = container.querySelectorAll('.top-material-item');

    items.forEach(item => {
        item.classList.remove('selected');
    });

    selectedElement.classList.add('selected');
}

function selectTopMaterial(selectedElement) {
    const container = document.getElementById('topColors');
    const items = container.querySelectorAll('.top-material-item');

    items.forEach(item => {
        item.classList.remove('selected');
    });

    selectedElement.classList.add('selected');
}

function enforceSingleSelection(containerId, radioName) {
    const colorContainer = document.getElementById(containerId);
    // Remove previous event listeners
    colorContainer.querySelectorAll(`input[type="radio"][name="${radioName}"]`)
        .forEach(radio => {
            let newRadio = radio.cloneNode(true);
            radio.parentNode.replaceChild(newRadio, radio);
        });

    // Add new event listeners
    colorContainer.querySelectorAll(`input[type="radio"][name="${radioName}"]`)
        .forEach(radioButton => {
            radioButton.addEventListener('click', function() {
                colorContainer.querySelectorAll(`input[type="radio"][name="${radioName}"]`)
                    .forEach(otherButton => {
                        if (otherButton !== radioButton) {
                            otherButton.checked = false;
                            const label = document.querySelector(`label[for="${otherButton.id}"]`);
                            if (label) {
                                const img = label.querySelector('img');
                                if (img) {
                                    img.classList.remove('selected');
                                }
                            }
                        }
                    });

                const label = document.querySelector(`label[for="${radioButton.id}"]`);
                if (label) {
                    const img = label.querySelector('img');
                    if (img) {
                        img.classList.add('selected');
                    }
                }
            });
        });
}