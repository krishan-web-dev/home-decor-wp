jQuery(document).ready(function ($) {
    $(".wp-block-woocommerce-product-collection").each(function () {
        // Wrap the block inside a new structure
        $(this).wrap('<div class="container mx-auto"></div>').parent().wrap('<section class="product-collection"></section>');
    });
});

jQuery(document).ready(function($) {
    // Initialize checkout steps
    function initCheckoutSteps() {
        // Hide all steps except the first one
        $('.checkout-step').not('#customer-info-step').hide();
        
        // Update progress bar
        updateProgressBar('customer-info-step');
    }
    
    // Handle next step button
    $(document).on('click', '.next-step', function(e) {
        e.preventDefault();
        var currentStep = $(this).closest('.checkout-step');
        var nextStepId = $(this).data('next');
        
        // Validate current step before proceeding
        if (validateStep(currentStep.attr('id'))) {
            currentStep.hide();
            $('#' + nextStepId).show();
            updateProgressBar(nextStepId);
            
            // Scroll to top of next step
            $('html, body').animate({
                scrollTop: $('#' + nextStepId).offset().top - 20
            }, 300);
        }
    });
    
    // Handle previous step button
    $(document).on('click', '.prev-step', function(e) {
        e.preventDefault();
        var currentStep = $(this).closest('.checkout-step');
        var prevStepId = $(this).data('prev');
        
        currentStep.hide();
        $('#' + prevStepId).show();
        updateProgressBar(prevStepId);
        
        // Scroll to top of previous step
        $('html, body').animate({
            scrollTop: $('#' + prevStepId).offset().top - 20
        }, 300);
    });
    
    // Validate step fields
    function validateStep(stepId) {
        var isValid = true;
        
        // Basic validation example - extend as needed
        if (stepId === 'customer-info-step') {
            $('#' + stepId + ' input[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('border-red-500');
                    isValid = false;
                } else {
                    $(this).removeClass('border-red-500');
                }
            });
        }
        
        return isValid;
    }
    
    // Update progress bar visualization
    function updateProgressBar(activeStep) {
        // Reset all steps
        $('.checkout-progress-step').removeClass('active completed').addClass('inactive');
        
        if (activeStep === 'customer-info-step') {
            $('.checkout-progress-step[data-step="1"]').removeClass('inactive').addClass('active');
        } 
        else if (activeStep === 'shipping-step') {
            $('.checkout-progress-step[data-step="1"]').removeClass('inactive').addClass('completed');
            $('.checkout-progress-step[data-step="2"]').removeClass('inactive').addClass('active');
        }
        else if (activeStep === 'payment-step') {
            $('.checkout-progress-step[data-step="1"], .checkout-progress-step[data-step="2"]').removeClass('inactive').addClass('completed');
            $('.checkout-progress-step[data-step="3"]').removeClass('inactive').addClass('active');
        }
    }
    
    // Initialize on page load
    initCheckoutSteps();
});