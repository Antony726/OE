document.addEventListener('DOMContentLoaded', () => {
    const countdownElement = document.getElementById('countdown');
    const targetDate = new Date('2024-04-20T21:50:00'); 

    function updateCountdown() {
        const now = new Date();
        const timeDifference = targetDate - now;

        if (timeDifference <= 0) {
            countdownElement.textContent = 'Countdown Finished';
        } else {
            const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

            countdownElement.textContent = formatTime(days) + ':' + formatTime(hours) + ':' + formatTime(minutes) + ':' + formatTime(seconds);
            if(days===0 && hours===0 && minutes===0 && seconds===0 ){
                sttop();
            }
        }

        requestAnimationFrame(updateCountdown);
    }

    function formatTime(time) {
        return time < 10 ? '0' + time : time;
    }

    function sttop(){
        window.open('index.php','_self');
        
    }

    updateCountdown(); 
});
