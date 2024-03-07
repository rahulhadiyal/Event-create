/**
 *  Page auth register multi-steps
 */

'use strict';

// Select2 (jquery)
$(function () {
  var select2 = $('.select2');

  // select2
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        placeholder: 'Select an country',
        dropdownParent: $this.parent()
      });
    });
  }
});

// Multi Steps Validation
// --------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const stepsValidation = document.querySelector('#multiStepsValidation');
    if (typeof stepsValidation !== undefined && stepsValidation !== null) {
      // Multi Steps form
      const stepsValidationForm = stepsValidation.querySelector('#multiStepsForm');
      // Form steps
      const stepsValidationFormStep1 = stepsValidationForm.querySelector('#accountDetailsValidation');
      const stepsValidationFormStep2 = stepsValidationForm.querySelector('#personalInfoValidation');
      const stepsValidationFormStep3 = stepsValidationForm.querySelector('#businessValidation');
      const stepsValidationFormStep4 = stepsValidationForm.querySelector('#billingLinksValidation');
      // Multi steps next prev button
      const stepsValidationNext = [].slice.call(stepsValidationForm.querySelectorAll('.btn-next'));
      const stepsValidationPrev = [].slice.call(stepsValidationForm.querySelectorAll('.btn-prev'));

      const multiStepsExDate = document.querySelector('.multi-steps-exp-date'),
        multiStepsCvv = document.querySelector('.multi-steps-cvv'),
        multiStepsMobile = document.querySelector('.multi-steps-mobile'),
        multiStepsPinCode = document.querySelector('.multi-steps-pin-code'),
        multiStepsCard = document.querySelector('.multi-steps-card');

      // Expiry Date Mask
      if (multiStepsExDate) {
        new Cleave(multiStepsExDate, {
          date: true,
          delimiter: '/',
          datePattern: ['m', 'y']
        });
      }

      // CVV
      if (multiStepsCvv) {
        new Cleave(multiStepsCvv, {
          numeral: true,
          numeralPositiveOnly: true
        });
      }

      // Mobile
      if (multiStepsMobile) {
        new Cleave(multiStepsMobile, {
          phone: true,
          phoneRegionCode: 'IN'
        });
      }

      // Pincode
      if (multiStepsPinCode) {
        new Cleave(multiStepsPinCode, {
          delimiter: '',
          numeral: true
        });
      }

      // Credit Card
      if (multiStepsCard) {
        new Cleave(multiStepsCard, {
          creditCard: true,
          onCreditCardTypeChanged: function (type) {
            if (type != '' && type != 'unknown') {
              document.querySelector('.card-type').innerHTML =
                '<img src="' + assetsPath + 'img/icons/payments/' + type + '-cc.png" height="28"/>';
            } else {
              document.querySelector('.card-type').innerHTML = '';
            }
          }
        });
      }

      let validationStepper = new Stepper(stepsValidation, {
        linear: true
      });

      // Account details
      const multiSteps1 = FormValidation.formValidation(stepsValidationFormStep1, {
        fields: {
          multiStepsEmail: {
            validators: {
              notEmpty: {
                message: 'Please enter email address'
              },
              regexp: {
                regexp: /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/,
                message: 'Please enter valid email address.'
              }
            }
          },
          multiStepsOtp: {
            validators: {
              notEmpty: {
                message: 'Please enter otp.'
              },
              numeric: {
                message: 'Please enter only number.'
              }
            }
          },
          multiStepsPass: {
            validators: {
              notEmpty: {
                message: 'Please enter password'
              },
              regexp: {
                regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~`!@#$%^&*()-+=|\{}[\]:;'?/,.<>])[A-Za-z\d~`!@#$%^&*()-+=|\{}[\]:;'?/,.<>]{8,}$/,
                message: 'Enter password with minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character'
              }
            }
          },
          multiStepsConfirmPass: {
            validators: {
              notEmpty: {
                message: 'Confirm Password is required'
              },
              identical: {
                compare: function () {
                  return stepsValidationFormStep1.querySelector('[name="multiStepsPass"]').value;
                },
                message: 'The password and its confirm are not the same'
              }
            }
          },
          referral_code: {
            validators: {
              stringLength: {
                max: 8,
                message: 'referral code must be 8 digits.'
              },
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            // Use this for enabling/changing valid/invalid class
            // eleInvalidClass: '',
            eleValidClass: '',
            rowSelector: function (field, ele) {
              // field is the field name
              // ele is the field element
              switch (field) {
                // case 'multiStepsEmail':
                //     return '.col-sm-6';
                case 'multiStepsPass':
                  return '.col-sm-6';
                case 'multiStepsConfirmPass':
                  return '.col-sm-6';
                default:
                  return '.row';
              }
            }
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      }).on('core.form.valid', function () {
        // Jump to the next step when all fields in the current step are valid
        validationStepper.next();
      });

      // Personal info
      const multiSteps2 = FormValidation.formValidation(stepsValidationFormStep2, {
        fields: {
          multiStepsFirstName: {
            validators: {
              notEmpty: {
                message: 'Please enter first name.'
              },
              regexp: {
                regexp: /^[a-zA-Z]+$/,
                message: 'First name can only contain alphabetic characters.'
              }
            }
          },
          multiStepsLastName: {
            validators: {
              notEmpty: {
                message: 'Please enter last name.'
              },
              regexp: {
                regexp: /^[a-zA-Z]+$/,
                message: 'Last name can only contain alphabetic characters.'
              }
            }
          },
          multiStepsMobile: {
            validators: {
              notEmpty: {
                message: 'Please enter mobile number.'
              },
            //   stringLength: {
            //     max: 10,
            //     message: 'Mobile number must be 10 digits.'
            //   },
            //   stringLength: {
            //     min: 10,
            //     message: 'Mobile number must be 10 digits.'
            //   },
              numeric: {
                message: 'Mobile number must be numeric.'
              },
              regexp: {
                regexp: /^[6789]\d{9}$/,
                message: 'Please enter a valid mobile number.'
              }
            }
          },
          multiStepsPinCode: {
            validators: {
              notEmpty: {
                message: 'Please enter pin code.'
              },
              stringLength: {
                min: 6, // Set the minimum length to 6
                message: 'The pin code must be at least 6 characters'
            }
            }
          },
          multiStepsCountry: {
            validators: {
              notEmpty: {
                message: 'Please select country.'
              }
            }
          },
          multiStepsZone: {
            validators: {
              notEmpty: {
                message: 'Please select zone.'
              }
            }
          },
          multiStepsState: {
            validators: {
              notEmpty: {
                message: 'Please select state.'
              }
            }
          },
          multiStepsRegion: {
            validators: {
              notEmpty: {
                message: 'Please select region.'
              }
            }
          },
          multiStepsArea: {
            validators: {
              notEmpty: {
                message: 'Please select Area.'
              }
            }
          },
          multiStepsCity: {
            validators: {
              notEmpty: {
                message: 'Please select city.'
              }
            }
          },
          multiStepsLandmark: {
            validators: {
              notEmpty: {
                message: 'Please enter landmark.'
              }
            }
          },
          multiStepsAddress: {
            validators: {
              notEmpty: {
                message: 'Please enter your Address.'
              }
            }
          },
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: function (field, ele) {
              switch (field) {
                case 'multiStepsFirstName':
                  return '.col-sm-6';
                case 'multiStepsAddress':
                  return '.col-sm-6';
                case 'multiStepsMobile':
                  $('#contact_error').html('');
                  return '.mobile-number';
                case 'multiStepsPinCode':
                  return '.pinCode';
                default:
                  return '.row';
              }
            }
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        }
      }).on('core.form.valid', function () {
        // Jump to the next step when all fields in the current step are valid
        validationStepper.next();
      });

      const gstPattern = /^(\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[A-Z\d]{1}[A-Z\d]{1})$/;
      const aadharPattern = /^\d{12}$/;
      const panPattern = /^([A-Za-z]{5}\d{4}[A-Za-z]{1})$/;

      const multiSteps3 = FormValidation.formValidation(stepsValidationFormStep3, {
        fields: {
          multiStepsGst: {
            validators: {
              notEmpty: {
                message: 'Please enter GST number'
              },
              regexp: {
                regexp: gstPattern,
                message: 'Invalid GST Number'
              }
            }
          },
          multiStepsAadharCard: {
            validators: {
              notEmpty: {
                message: 'Please enter Aadhar card number'
              },
              regexp: {
                regexp: aadharPattern,
                message: 'Invalid Aadhar Number'
              }
            }
          },
          multiStepsPancard: {
            validators: {
              notEmpty: {
                message: 'Please enter PAN card number'
              },
              regexp: {
                regexp: panPattern,
                message: 'Invalid PAN Number'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: function (field, ele) {
              switch (field) {
                case 'multiStepsGst':
                case 'multiStepsAadharCard':
                case 'multiStepsPancard':
                  return '.col-sm-6';
                default:
                  return '.row';
              }
            }
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        }
      }).on('core.form.valid', function () {
        // Jump to the next step when all fields in the current step are valid
        validationStepper.next();
      });

      // Social links
      const multiSteps4 = FormValidation.formValidation(stepsValidationFormStep4, {
        fields: {
          multiStepsCard: {
            validators: {
              notEmpty: {
                message: 'Please enter card number'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            // Use this for enabling/changing valid/invalid class
            // eleInvalidClass: '',
            eleValidClass: '',
            rowSelector: function (field, ele) {
              // field is the field name
              // ele is the field element
              switch (field) {
                case 'multiStepsCard':
                  return '.col-md-12';

                default:
                  return '.col-dm-6';
              }
            }
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      }).on('core.form.valid', function () {
        // You can submit the form
        //stepsValidationForm.onsubmit();
        // or send the form data to server via an Ajax request
        // To make the demo simple, I just placed an alert
        //alert('Submitted..!!');
      });

      stepsValidationNext.forEach(item => {
        item.addEventListener('click', event => {
          // When click the Next button, we will validate the current step
          switch (validationStepper._currentIndex) {
            case 0:
              multiSteps1.validate();
              break;

            case 1:
              multiSteps2.validate();
              break;

            case 2:
              multiSteps3.validate();
              break;
            case 3:
              multiSteps4.validate();
              break;

            default:
              break;
          }
        });
      });

      stepsValidationPrev.forEach(item => {
        item.addEventListener('click', event => {
          switch (validationStepper._currentIndex) {
            case 3:
              validationStepper.previous();
              break;
            case 2:
              validationStepper.previous();
              break;

            case 1:
              validationStepper.previous();
              break;

            case 0:

            default:
              break;
          }
        });
      });
    }
  })();
  $('#multiStepsForm').on('submit', function (e) {
    $('#loader').show();
    $("#show_msg").html('');
    e.preventDefault();
    var fromData = $(this).serialize();
    $.ajax({
      url: $("#action_url").val(),
      type: "POST",
      data: fromData,
      dataType: 'json',
      success: function (result) {
        if (result.status == 200) {
          if (result.data == 0) {
            localStorage.setItem("success", result.msg);
            window.location.href = result.url;
          }
          else {
            // openPaymentPopup(result.data);
            // console.log('{{$paymentGateway->id}}');
            if($('#payment_id').val()== 1){
              openPaymentPopup(result.data);
            }else if($('#payment_id').val() == 2){
                initiateCashFreePayment(result.data);
            }
          }
        }
        else {
          let error_msg = '';
          $.each(result.msg, function (key, val) {
            error_msg += val + '<br>';
          });
          $("#show_msg").html('<div class="alert alert-solid-danger d-flex align-items-center" role="alert"><i class="mdi mdi-alert-circle-outline me-2"></i>' + error_msg + '</div>');
        }
        $('#loader').hide();
      }
    });
  });
});
