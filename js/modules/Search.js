import $ from 'jquery';
class Search{
    // 1.descrip and create/initiate our object
    constructor(){
        this.openButton = $(".js-search-trigger");
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $(".search-overlay");
        this.events();
        this.isOverlayOpen = false;
    }
    // 2. events
    events(){
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
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
        if(e.keyCode == 83 && !this.isOverlayOpen){
            this.openOverlay();
        }
        if(e.keyCode == 27 && this.isOverlayOpen){
            this.closeOverlay();
        }
    }
}
export default Search; // Allow us to import this code to main script file