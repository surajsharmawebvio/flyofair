// Contact form handling
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            const submitButton = contactForm.querySelector('button[type="submit"]');
            const submitText = submitButton.querySelector('.submit-text');
            const originalText = submitText.textContent;
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitText.textContent = 'Please wait...';
            
            try {
                const response = await axios.post('/api/contact/submit', {
                    name: formData.get('name'),
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    subject: formData.get('subject'),
                    message: formData.get('message')
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData.get('_token')
                    }
                });
                
                await Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: response.data.message || 'Thank you for contacting us. We will get back to you soon.',
                    confirmButtonText: 'OK'
                });
                
                // Reset form
                contactForm.reset();
                
            } catch (error) {
                console.error('Error submitting contact form:', error);
                let errMsg = 'Failed to send message. Please try again.';
                
                if (error.response && error.response.status === 422 && error.response.data.errors) {
                    const firstKey = Object.keys(error.response.data.errors)[0];
                    const firstMsg = error.response.data.errors[firstKey][0];
                    errMsg = firstMsg;
                } else if (error.response && error.response.data && error.response.data.message) {
                    errMsg = error.response.data.message;
                }
                
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errMsg,
                    confirmButtonText: 'OK'
                });
            } finally {
                // Re-enable submit button
                submitButton.disabled = false;
                submitText.textContent = originalText;
            }
        });
    }
});
