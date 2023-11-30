function masonryInit(){
    var container = document.querySelector('#image-container');
        var masonry = new Masonry(container, {
            itemSelector: '.image-item',
            columnWidth: '.image-item',
            gutter: 20
        });
}

// Run Masonry and modal initialization after the DOM has fully loaded
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('uploadForm').reset();
    masonryInit();
});