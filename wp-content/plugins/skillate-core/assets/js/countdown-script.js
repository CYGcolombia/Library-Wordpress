document.addEventListener('DOMContentLoaded', () => {

	let timer = [];
	Array.prototype.slice
	.call(document.getElementsByClassName('skillate-home-countdown-wrapper'))
	.forEach( (instance, i) => {
		timer[i] = setInterval(function() {
			const timeLeft = parseInt(instance.getAttribute('data-enddate')) - Math.floor(Date.now() / 1000);
			const seconds   = timeLeft % 60;
			const minutes   = ((timeLeft - seconds) % 3600) / 60;
			const hours     = ((timeLeft - minutes * 60 - seconds) % 86400) / 3600;
			// const days 		= parseInt((timeLeft - hours / 3600 / minutes * 60 - seconds) / 86400 );
            
            // instance.querySelector( '.days' ).innerHTML = days;
            instance.querySelector( '.hours' ).innerHTML = hours;
            instance.querySelector( '.minutes' ).innerHTML = minutes;
            instance.querySelector( '.second' ).innerHTML = seconds;
            
		}, 1000);
    });
    
});
