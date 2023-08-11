export default {

    methods: {
        makeParagraph(obj) {
            return `<p class="event-details__text-1">${obj.data.text}</p>`
        },

        makeImage(obj) {
            const caption = obj.data.caption ? `<div class="text-center">
                <p>${obj.data.caption}</p>
            </div>` : ''
            return `<div class="news-details__img mt-2">
            <img src="${obj.data.file.url}" alt="${obj.data.caption}">
        </div> ${caption}`
        },
        
        makeHeader(obj) {
            return `<h${obj.data.level} class="event-details__text-2">${obj.data.text}</h${obj.data.level}>`
        },

        makeList(obj) {
            if(obj.data.style === 'unordered') {
                const list = obj.data.items.map(item => {
                    return `<li>
                    <div class="icon">
                        <span class="fa fa-check"></span>
                    </div>
                    <div class="text">
                        <p>${item}</p>
                    </div>
                </li>`
                })
                return `<ul class="list-unstyled donation-details__summary-list">
                ${list.join('')}
            </ul>`
            } else {
                const list = obj.data.items.map(item => {
                    return ` <li>
                    <div class="icon">
                        <span class="fa fa-check"></span>
                    </div>
                    <div class="text">
                        <p>${item}</p>
                    </div>
                </li>`
                })
                return `<ul class="list-unstyled donation-details__summary-list">
                ${list.join('')}
            </ul>`
            }
        },
        makeQuote(obj) {
            return `<div>
            <blockquote> 
                <span style="transform: scaleX(-1) !important;" class="icon-double-quotes"></span>
                        ${obj.data.text}
                <span class="icon-double-quotes"></span>
            </blockquote>
            <p>${obj.data.caption}</p>
            </div>`
        },
    }
}