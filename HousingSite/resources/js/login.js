// --- PANEL SLIDE ---
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

// --- FORMAT PHONE NUMBER AUTOMATICALLY ---
const phoneInput = document.getElementById('phoneInput');
if (phoneInput) {
    phoneInput.addEventListener("input", () => {
        let val = phoneInput.value.replace(/\s+/g, '');

        if (val.startsWith("07")) {
            val = "+254" + val.slice(1);
        } 
        
        if (!val.startsWith("+254")) return;    
        if (val.length > 13) val = val.slice(0, 13);

        phoneInput.value = val;
    });
}

// Reset to tenant form when switching back to sign-in
signInButton.addEventListener('click', () => {
    // Reset form to tenant mode
    document.getElementById('formHeading').textContent = 'Create Account';
    document.getElementById('tenantFields').style.display = 'block';
    document.getElementById('agentFields').style.display = 'none';
    document.getElementById('userRole').value = 'tenant';
    document.getElementById('submitBtn').textContent = 'Sign Up';
    
    // Remove required attributes from agent fields
    const agentFields = document.querySelectorAll('#agentFields input, #agentFields textarea');
    agentFields.forEach(field => {
        field.required = false;
    });
});

// Function to show agent form (called from the blade file)
function showAgentForm() {
    document.getElementById('formHeading').textContent = 'Become a Verified Agent';
    document.getElementById('tenantFields').style.display = 'none';
    document.getElementById('agentFields').style.display = 'block';
    document.getElementById('userRole').value = 'agent';
    document.getElementById('submitBtn').textContent = 'Apply as Agent';
    
    // Add required attributes to agent fields
    const agentFields = document.querySelectorAll('#agentFields input, #agentFields textarea');
    agentFields.forEach(field => {
        field.required = true;
    });
}