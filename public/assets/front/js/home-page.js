document.addEventListener('DOMContentLoaded', function () {
            var accordion = document.getElementById('faqAccordion');
            if (!accordion) return;

            accordion.querySelectorAll('.accordion-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var panel = document.querySelector(button.getAttribute('data-bs-target'));
                    if (!panel) return;

                    var shouldOpen = !panel.classList.contains('show');
                    accordion.querySelectorAll('.accordion-collapse').forEach(function (item) {
                        item.classList.remove('show');
                    });
                    accordion.querySelectorAll('.accordion-button').forEach(function (item) {
                        item.classList.add('collapsed');
                        item.setAttribute('aria-expanded', 'false');
                    });

                    if (shouldOpen) {
                        panel.classList.add('show');
                        button.classList.remove('collapsed');
                        button.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
function ajaxCall() {
            this.send = function(data, url, method, success, type) {
                type = 'json';
                var successRes = function(data) {
                        success(data);
                    }
                    var errorRes = function(xhr, ajaxOptions, thrownError) {            
                        // console.log(xhr.responseText);
                    }   
                    jQuery.ajax({
                        url: url,
                        type: method,
                        data: data,
                        success: successRes,
                        error: errorRes,
                        dataType: type,
                        timeout: 60000,
                        xhrFields: {},
                });
            }
        }
    
        function locationInfo() {
            var rootUrl = "https://geodata.phplift.net/api/index.php";
            var call = new ajaxCall();
            this.getCities = function(id) {
                jQuery(".cities option:gt(0)").remove();
                var url = rootUrl+'?type=getCities&countryId='+ '&stateId=' + id;
                var method = "post";
                var data = {};
                jQuery('.cities').find("option:eq(0)").html("Please wait..");
                call.send(data, url, method, function(data) {
                    jQuery('.cities').find("option:eq(0)").html("Select City");
                        var listlen = Object.keys(data['result']).length;
                        if(listlen > 0)
                        {
                            jQuery.each(data['result'], function(key, val) {
                                var option = `<option value='${val.name}'>${val.name}</option>`;
                                jQuery('.cities').append(option);
                            });
                        }
                        jQuery(".cities").prop("disabled",false);
                });
        };

        this.getStates = function(id) {
            jQuery(".states option:gt(0)").remove();
            jQuery(".cities option:gt(0)").remove();
            var stateClasses = jQuery('#stateId').attr('class');

            
            var url = rootUrl+'?type=getStates&countryId=' + id;
            var method = "post";
            var data = {};
            jQuery('.states').find("option:eq(0)").html("Please wait..");
            call.send(data, url, method, function(data) {
                jQuery('.states').find("option:eq(0)").html("Select State");
                
                    jQuery.each(data['result'], function(key, val) {
                        // var option = jQuery('');
                        var option = `<option value='${val.name}' stateid='${val.id}'>${val.name}</option>`;
                        // option.attr('value', val.name).text(val.name);
                        // option.attr('stateid', val.id);
                        jQuery('.states').append(option);
                    });
                    jQuery(".states").prop("disabled",false);
                
            });
        };

        this.getCountries = function() {
            var url = rootUrl+'?type=getCountries';
            var method = "post";
            var data = {};
            jQuery('.countries').find("option:eq(0)").html("Please wait..");
            call.send(data, url, method, function(data) {
                jQuery('.countries').find("option:eq(0)").html("Select Country");
                jQuery.each(data['result'], function(key, val) {
                    var option = `<option value='${val.name}' countryid='${val.id}'>${val.name}</option>`;
                    // option.attr('value', val.name).text(val.name);
                    // option.attr('countryid', val.id);
                    jQuery('.countries').append(option);
                });
                    // jQuery(".countries").prop("disabled",false);
                
            });
        };

        }

        // Owl Carousel measures element dimensions while it starts.  Delay these
        // below-the-fold carousels until the browser has completed the first paint
        // so their measurements do not block the hero or force layout during LCP.
        var initializeNonCriticalCarousels = function () {
        var $owl_carousel_4col = $('.owl-carousel-4col');

        if ( $owl_carousel_4col.length > 0 ) {
            if(!$owl_carousel_4col.hasClass("owl-carousel")){
                $owl_carousel_4col.addClass("owl-carousel owl-theme");
            }
            $owl_carousel_4col.each(function() {
                var $carousel = $(this);
                var labelInstructorCarouselControls = function () {
                    $carousel.find('.owl-nav .owl-prev')
                        .removeAttr('role')
                        .attr('aria-label', 'Previous instructors');
                    $carousel.find('.owl-nav .owl-next')
                        .removeAttr('role')
                        .attr('aria-label', 'Next instructors');
                };
                $carousel.on('initialized.owl.carousel refreshed.owl.carousel translated.owl.carousel', labelInstructorCarouselControls);
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    // rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    // Rewind gives visitors the same continuous browsing
                    // experience without Owl Carousel cloning every slide.
                    loop: false,
                    rewind: true,
                    items: 4,
                    margin: 15,
                    dots: false,
                    nav: data_nav,
                    navElement: 'button',
                    navText: [
                        '<i class="fa fa-chevron-left"></i>',
                        '<i class="fa fa-chevron-right"></i>'
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            center: true
                        },
                        480: {
                            items: 1,
                            center: false
                        },
                        600: {
                            items: 3,
                            center: false
                        },
                        750: {
                            items: 3,
                            center: false
                        },
                        960: {
                            items: 3
                        },
                        1170: {
                            items: 4
                        },
                        1300: {
                            items: 4
                        }
                    }
                });
                labelInstructorCarouselControls();
            });
        }
        
        var labelTestimonialCarouselControls = function ($carousel) {
            $carousel.find('.owl-nav .owl-prev')
                .removeAttr('role')
                .attr('aria-label', 'Previous testimonials');
            $carousel.find('.owl-nav .owl-next')
                .removeAttr('role')
                .attr('aria-label', 'Next testimonials');
            $carousel.find('.owl-dots .owl-dot').each(function (index) {
                $(this).attr('aria-label', 'Show testimonial slide ' + (index + 1));
                $(this).attr('aria-current', $(this).hasClass('active') ? 'true' : 'false');
            });
        };

        var $owl_carousel_3col = $('.owl-carousel-3col');
    
        if ( $owl_carousel_3col.length > 0 ) {
            if(!$owl_carousel_3col.hasClass("owl-carousel")){
                $owl_carousel_3col.addClass("owl-carousel owl-theme");
            }
            $owl_carousel_3col.each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                var $carousel = $(this);
                $carousel.on('initialized.owl.carousel refreshed.owl.carousel translated.owl.carousel', function () {
                    labelTestimonialCarouselControls($(this));
                });
                $carousel.owlCarousel({
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    // Avoid cloned testimonial cards in the initial DOM.
                    loop: false,
                    rewind: true,
                    items: 3,
                    margin: 15,
                    dots: data_dots,
                    nav: data_nav,
                    navText: [
                        '<i class="fa fa-chevron-left"></i>',
                        '<i class="fa fa-chevron-right"></i>'
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            center: false
                        },
                        480: {
                            items: 1,
                            center: false
                        },
                        600: {
                            items: 1,
                            center: false
                        },
                        750: {
                            items: 2,
                            center: false
                        },
                        960: {
                            items: 2
                        },
                        1170: {
                            items: 3
                        },
                        1300: {
                            items: 3
                        }
                    }
                });
                labelTestimonialCarouselControls($carousel);
            });
        }
        };

        var scheduleNonCriticalCarousels = function () {
            var runWhenIdle = function () {
                if ('requestIdleCallback' in window) {
                    window.requestIdleCallback(initializeNonCriticalCarousels, { timeout: 1500 });
                    return;
                }

                window.setTimeout(initializeNonCriticalCarousels, 250);
            };

            // Two animation frames ensure the initial frame has been presented
            // before the carousel plugin reads and writes layout properties.
            window.requestAnimationFrame(function () {
                window.requestAnimationFrame(runWhenIdle);
            });
        };

        if (document.readyState === 'complete') {
            scheduleNonCriticalCarousels();
        } else {
            window.addEventListener('load', scheduleNonCriticalCarousels, { once: true });
        }
