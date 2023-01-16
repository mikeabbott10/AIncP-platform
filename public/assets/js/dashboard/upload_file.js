const populateForm = (subj) => {
    $('#newsubjectform input[name=subjname]').val(subj.name).change()
    $('#newsubjectform input[name=subjsurname]').val(subj.surname).change()
    $('#newsubjectform input[name=subjcode]').val(subj.code).change()
    $('#newsubjectform input[name=subjaha]').val(subj.aha).change()
    $('#newsubjectform input[name=subjmacs]').val(subj.macs).change()
    $('#newsubjectform input[name=subjhemi]').val(subj.hemi).change()
    $('#newsubjectform select[name=subjgender]').val(subj.gender).change()
    $('#newsubjectform select[name=subjdominance]').val(subj.dominance).change()
}

const changeInputStates = (state) => {
    $('#newsubjectform input:not([type=submit]):not([type=file])').attr('disabled', state)
    $('#newsubjectform select:not([name=subjectselection]):not(name=data_tag)').attr('disabled', state)
    $('#newsubjectform input:not([type=submit]):not([type=file])').prop('disabled', state)
    $('#newsubjectform select:not([name=subjectselection]):not(name=data_tag)').prop('disabled', state)
}

jQuery(function ($) {$(function () {
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    
    $('select[name=subjectselection').on('change', event => {
        let _this = $(event.target);
        let selectedValue = _this.find("option:selected").val()
        if(selectedValue==='-1'){
            // enable and clear inputs inside the form
            $('#newsubjectform input:not([type=submit])').val('').change();
            $('#newsubjectform select:not([name=subjectselection]):not(name=data_tag)').val('').change();
            changeInputStates(false);
        }else{
            // disable and populate inputs inside the form
            let selectedSubject = subjects.filter(subj => {
                return subj.ID === selectedValue
            });
            populateForm(selectedSubject[0]);
            changeInputStates(true);
        }
    })
})})