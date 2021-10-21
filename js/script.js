{
    const handleTimeUpdateAudioStory =(e)=>{
        console.log(e.currentTarget.currentTime)
        if (e.currentTarget.currentTime < 0.64 && e.currentTarget.currentTime > 0.11){

            let destination = document.querySelector(`#first`);

            destination.scrollIntoView({
                behavior: 'smooth',
                block: `start`
            }); 
        };
        if (e.currentTarget.currentTime > 29.30 && e.currentTarget.currentTime < 29.80) {
            let destination = document.querySelector(`#second`);

            destination.scrollIntoView({
                behavior: 'smooth',
                block: `start`
            }); 
        }

        if (e.currentTarget.currentTime > 57.30 && e.currentTarget.currentTime < 57.40) {
            let destination = document.querySelector(`#third`);

            destination.scrollIntoView({
                behavior: 'smooth',
                block: `start`
            });
        }

        if (e.currentTarget.currentTime > 94.60 && e.currentTarget.currentTime < 94.80) {
            let destination = document.querySelector(`#fourth`);

            destination.scrollIntoView({
                behavior: 'smooth',
                block: `start`
            });
        }
        }

    
    const handleChangeButtonFile =(e)=>{
        let fileName= ``;
        fileName = e.target.value.split(`\\`)[2];
        console.log(fileName);
        let label = e.currentTarget.nextElementSibling;
        label.innerHTML = fileName; 
        let file = event.target.files[0];
        let blobURL = URL.createObjectURL(file);
        let video =`<video width="320" height="220" controls><source src="${blobURL}" type="video/mp4"><source src="movie.ogg" type="video/ogg">Your browser does not support the video tag.</video>`
        document.querySelector(`.video`).innerHTML=video;
    }

    const handleSubmitForm = e => {
        e.preventDefault();
        const $form = e.currentTarget;
        postComment($form.getAttribute('action'), formdataToJson($form));
    }

    const handleInputRatingButton = e => {
        const $form = e.currentTarget.parentElement.parentElement.parentElement;
        let $amountLike = e.currentTarget.parentElement.getElementsByTagName('p')['0'].firstElementChild;
        console.log($form);
        console.log($amountLike);   
        postRating($form.getAttribute('action'), formdataToJson($form), $amountLike);
    }

    const postRating = async (url, data, $count) => {
        const response = await fetch(url, {
            method: "POST",
            headers: new Headers({
                'Content-Type': 'application/json'
            }),
            body: JSON.stringify(data)
        });

        const returned = await response.json();
        console.log(returned);
        showCount(returned, $count);
    };

    const showCount = (numbers, $count) => {
        if ($count) {
            $count.textContent = numbers['like']['COUNT(*)'];
            console.log(numbers.info)
            if(numbers['info']!==undefined){
                const $info =`<div class="info"><span class="closebtn">&times;</span><p>${numbers.info}</p></div>`;
                const $container = document.querySelector(`.container`);
                $container.innerHTML=$info;
            }
        }

    }

    const formdataToJson = $from => {
        const data = new FormData($from);
        const obj = {}
        data.forEach((value, key) => {
            console.log(key + ' : ' + value);
            obj[key] = value;

        });
        return obj;
    }

    const postComment = async (url, data) => {

        const response = await fetch(url, {
            method: "POST",
            headers: new Headers({
                'Content-Type': 'application/json'
            }),
            body: JSON.stringify(data)
        });
        const returned = await response.json();
        console.log(returned);
        if (returned.error) {
            console.log(returned.error);
            document.querySelector(`.error`).textContent = returned.error;
        } else {
            showComments(returned);
        }
    };

    const showComments = comments => {
        console.log(comments)
        const $parent = document.querySelector('.ranglist-comments');
        $parent.innerHTML = ``;
        comments['comments'].forEach(comment => {
            const $licomment = document.createElement('li');
            $licomment.innerHTML = `<li class="ranglist-comment"><span class="subtitle">${comment.username}: </span>${comment.comment}</li>`;
            $parent.appendChild($licomment);
        });
        if(comments.info!==undefined){
            console.log(`het werkt`)
            const $info = `<div class="info"><span class="closebtn">&times;</span><p>${comments.info}</p></div>`;
            const $container = document.querySelector(`.container`);
            $container.innerHTML = $info;
        }
    };

    const init =()=>{
    document.documentElement.classList.add(`has-js`);

    const $commentForm = document.querySelector(`.form__comment`);
    if ($commentForm) {
        $commentForm.addEventListener('submit', handleSubmitForm);
    }

    const $audioStory= document.querySelector(`.section__two-audio`);
    if($audioStory){
        $audioStory.addEventListener('timeupdate', handleTimeUpdateAudioStory)
    }

    const $modal = document.querySelector(`#myModal`);
    if($modal){  
        const btn = document.querySelector(`#myBtn`);
        btn.addEventListener(`click`, () => {
            console.log('er werd op de knop geklikt');
            $modal.style.display = "block";        
        });

        window.addEventListener(`click`, (e) => {
            if (e.target == $modal) {
                console.log('er werd op de knop geklikt');
                $modal.style.display = "none";
            }
        });

        const span = document.querySelector(`.close`);
        span.addEventListener(`click`, () => {
            console.log('er werd op de knop geklikt');
            $modal.style.display = "none";
        });
    }

    const $closeBtn = document.querySelector(`.closebtn`);
    if($closeBtn){
        $closeBtn.addEventListener(`click`, (e) => {
            console.log('er werd op de knop geklikt');        
            e.currentTarget.parentElement.style.display = 'none'

        });
    }

    const ratingButtons = document.querySelectorAll(`.rating__js`)
    if (ratingButtons) {
        ratingButtons.forEach($button => $button.addEventListener(`input`, handleInputRatingButton))
    }

    const $inputFile = document.querySelector(`.button-file`);
    if($inputFile){
        $inputFile.addEventListener(`change`, handleChangeButtonFile)
    }
    }
    init();
}