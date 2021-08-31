let freelancerRadio = document.getElementById('freelancer-account');
let companyRadio = document.getElementById('company-account');
let companyFields = document.getElementById('company-fields');
let freelancerFields = document.getElementById('freelancer-fields');

freelancerRadio.addEventListener('click', () => {
    companyFields.style.display = 'none';
    freelancerFields.style.display = 'block';
});

companyRadio.addEventListener('click', () => {
    companyFields.style.display = 'block';
    freelancerFields.style.display = 'none';
})
