import $ from 'jquery';
class MyNotes{
    constructor(){
        this.events();
    }
    events(){
        $(".delete-note").on("click", this.deleteNote)
    }

    //Method
    deleteNote(){
        $.ajax({
            beforeSend: (xhr)   =>  {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/97',
            type: 'DELETE',
            success: (Response) => {
                console.log("congrates");
                console.log(Response);
            },
            error: (Response) => {
                console.log("Sorry");
                console.log(Response);
            } 
        });
    }
}
export default MyNotes;