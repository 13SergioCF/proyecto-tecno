document.addEventListener('livewire:load', function () {
    window.addEventListener('startTypingEffect', function () {
        Livewire.emit('addNextChunk'); 
    });

    window.addEventListener('continueTypingEffect', function () {
        setTimeout(() => Livewire.emit('addNextChunk'), 100); 
    });
});