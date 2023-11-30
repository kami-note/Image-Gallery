function modalinit(){
    document.addEventListener('alpine:init', () => {
        Alpine.data('modal', () => ({
            isOpen: false,
            open() {
                this.isOpen = true;
            },
            close() {
                this.isOpen = false;
            },
            submitForm() {
                document.getElementById('uploadForm').submit();
                this.close();
            },
            clickAway() {
                // Do nothing when clicking away
            }
        }));
    });
}

modalInit();