document.addEventListener("DOMContentLoaded", function () {

    const counters = document.querySelectorAll(".counter");

    const observer = new IntersectionObserver(function (entries, observer) {

        entries.forEach(entry => {

            if (!entry.isIntersecting) return;

            const counter = entry.target;
            const target = Number(counter.dataset.target);

            let count = 0;
            const increment = Math.max(1, Math.ceil(target / 100));

            function updateCounter() {

                count += increment;

                if (count < target) {
                    counter.textContent = count;
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }

            }

            updateCounter();

            observer.unobserve(counter);

        });

    }, {
        threshold: 0.5
    });

    counters.forEach(counter => observer.observe(counter));

});