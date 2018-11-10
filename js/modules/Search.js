import $ from 'jquery';
class Search{
    // 1.descrip and create/initiate our object
    constructor(){
        this.openButton = $(".js-search-trigger");
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results");
        this.events();
        this.isOverlayOpen = false;
        this.typingTimer;
        this.isSpinnerVisible = false;
        this.previusValue;
    }
    // 2. events
    events(){
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));
    }

    // 3. methods(functions/actions) 
    openOverlay(){
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.isOverlayOpen = true;
    }
    closeOverlay(){
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
    }
    keyPressDispatcher(e){
        if(e.keyCode == 83 && !this.isOverlayOpen && $("input", "textarea").is(":focus")){
            this.openOverlay();
        }
        if(e.keyCode == 27 && this.isOverlayOpen){
            this.closeOverlay();
        }
    }
    typingLogic(){
        if(this.searchField.val() != this.previusValue){
            clearTimeout(this.typingTimer);
            if(this.searchField.val()){
                if(!this.isSpinnerVisible){
                    this.resultsDiv.html("<div class='spinner-loader'></div>");
                    this.isSpinnerVisible = true;
                   }
                   this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
            } else{
               this.resultsDiv.html('');
               this.isSpinnerVisible = false; 
            }
          
        }    
       this.previusValue = this.searchField.val();
    }
    getResults(){9
        $.getJSON('http://localhost:3000/FictionalUniversity/wp-json/wp/v2/posts?search=' + this.searchField.val(), posts => {
            this.resultsDiv.html(`
                <h2 class="search-overlay__section-title">General Information</h2>
                <ul class="link-list min-list">
                    ${posts.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                </ul>
            `);
        });
    }
}
export default Search; // Allow us to import this code to main script file