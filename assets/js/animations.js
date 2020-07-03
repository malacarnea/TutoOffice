const ratio = .5
const options = {
    root: null,
    rootMargin: '0px',
    threshold: .5
}

const handleIntersect = function (entries, observer) {
    entries.forEach(function (entry) {
		if(entry.intersectionRatio>ratio){
//        if (entry.isIntersecting) {
            entry.target.classList.add('reveal-visible')
            observer.unobserve(entry.target)     
        }
    })
}
const observer = new IntersectionObserver(handleIntersect, options)
document.querySelectorAll('.reveal').forEach(function(r){
    observer.observe(r)
})
