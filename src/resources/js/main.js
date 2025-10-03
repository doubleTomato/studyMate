const getDataFunc = {
    getAlertData(msg, status = null){
        let returnData = '';
        returnData += `<h1><span class="${!status ? 'msg-con': ''}">${msg}</span>${!status ? ' 중 입니다.': ''}</h1>`;
        return returnData
    },
    getResponseData(msg, state, type=""){
        let returnData = "";
        let msgCon = type !== 'mail'? `<span class="msg-con">${msg}</span> ${state ==='success' ? '완료':'실패'}되었습니다.${state ==='success' ? '':'다시 시도해주세요.'}`:msg;
        returnData += `
                <p class="state-icon">
                    <i class="xi-${state === 'success' ? 'check-circle' : 'xi-error'} xi-3x"></i>
                </p>
                <h1>${msgCon}</h1>
            `;
        return returnData
    },
    getModalData(title, content){
        const returnMsg = {
            'title':`<h1>${title}</h1>`,
            'content':`${content}`
        }
        return returnMsg
    },
    getConfirmData(msg){
        let returnData = '';
        returnData += `
            <h1>${msg}</h1>
            <p class="state-icon">
                <i class="${msg === '삭제'? 'xi-warning' : ''} xi-3x"></i>
            </p>
            <p>${msg === '삭제'? '정말로 이 댓글을 삭제하시겠습니까?':''}</p>
        `;
        return returnData
    }
}

// 인풋 관련 함수들
export const commonFunc = {
    
    requireConfirm(thisV){
        console.log(thisV);
    },
    categoryReturn(idV){ // 
        $.ajax({
            url: '/category/default',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log('기본 카테고리:', data);

                let selectValue = "<option value=''>카테고리를 선택해주세요.</option>";

                data.forEach((v,i) => {
                    const {id, title, description} = v;
                    selectValue += `<option value="${id}" title="${description}">${title}</option>`;
                });
                // 화면에 표시할 때 처리
                $(`#${idV}`).html(selectValue);
            },
            error: function(err) {
                console.error('AJAX 요청 실패', err);
            }
        });
    },
    regionReturn(idV){ // 
        $.ajax({
            url: '/regions/default',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('지역:', data);

                let selectValue = "<option value=''>지역을 선택해주세요.</option>";

                data.forEach((v,i) => {
                    const { name } = v;
                    selectValue += `<option value="${i+1}" title="${name}">${name}</option>`;
                });
                // 화면에 표시할 때 처리
                $(`#${idV}`).html(selectValue);
            },
            error: function(err) {
                console.error('AJAX 요청 실패', err);
            }
        });
    },
    foldToggle(thisO){
        const foldObj = $(thisO).parent().parent().find(".fold-wrap");
        if($(foldObj).hasClass("fold")){
            $(foldObj).removeClass("fold");
            $(thisO).children("i").attr("class", "xi-caret-up");
        }else{
            $(foldObj).addClass("fold");
            $(thisO).children("i").attr("class", "xi-caret-down");
        }
    },

    //  체크 시 비활성화
    //c: checkbox, o: 비활성화 할 아이디 array
    checkDisabled(c,o){
        console.log($("#"+o).attr('disabled'));
        console.log($(c).is(":checked"));
        if(!$(c).is(":checked")){
            o.forEach((v) => {
                $("#"+v).attr("disabled",false);
            });
        }else{
            o.forEach((v) => {
                $("#"+v).attr("disabled",true);
                $("#"+v).val('');
                $('#'+v).val(null).trigger('change');
            });
        }
    },
    modalHide(typeV){
        $(".loading-sec .msg." + typeV).hide();
        $(".loading-sec").removeClass("active");
    },
    confirmOpen(){
        return new Promise((resolve) => {
            const okBtn = document.getElementById('modal-ok-btn');
            const closeBtn = document.getElementById('modal-close-btn');
            this.modalOpen('confirm', '삭제');

            const closeConfirm = (result) => {
                this.modalHide('confirm');
                okBtn.removeEventListener('click', onOk);
                closeBtn.removeEventListener('click', onClose);
                resolve(result);
            };

            const onOk = () => closeConfirm(true);
            const onClose = () => closeConfirm(false);

            okBtn.addEventListener('click',onOk);
            closeBtn.addEventListener('click',onClose);
        });
    },
    modalOpen(typeV ='', msg ='', state = null, type=""){
        let returnData = '';
        if(typeV === 'response'){
            returnData = getDataFunc.getResponseData(msg, state, type);
        }else if(typeV === 'alert'){
            returnData = getDataFunc.getAlertData(msg);
        }else if(typeV === 'confirm'){
            returnData = getDataFunc.getConfirmData(msg);
        }else{
            returnData = getDataFunc.getAlertData(msg, state);
        }



        $(".loading-sec .msg." + typeV + " .msg-con-wrap").html(`${returnData}`);
        $(".loading-sec .msg." + typeV ).show();
        $(".loading-sec").addClass("active");
        
    },modalResponseHidden(msg, state, type=""){
        setTimeout(() => {
            this.modalOpen('response', msg, state, type);
            setTimeout(() => {
                //$(".loading-sec").removeClass("active");
                this.modalHide('response');
            }, 1000);
        }, 1000);
    },
    //  form send
    async sendData(f, methodType, url="") {
        let msgCon = url === "" ? "등록" : "수정";
        // if(methodType === 'DELETE' && !confirm("정말 삭제하시겠습니까? 복구할 수 없습니다.")){
        msgCon = methodType === 'DELETE' ? '삭제': msgCon;
        if(methodType === 'DELETE' && !(await this.confirmOpen())){
            return;
        }
        if (!f.checkValidity()) {
            alert("필수 값을 넣지 않았습니다. 입력값을 다시 확인해주세요!");
            return;
        }
        if($("#end-date").val() == '' && !$("#durationdisable").is(':checked')){
            alert("종료 일자를 선택해주시거나 기간 제한 없음을 선택해주세요!");
            return;
        }if($("#region-sel").val() == '' && !$("#is-offline").is(":checked")){
            alert("지역을 선택해주시거나 온라인 제한을 선택해주세요!");
            return;
        }
        const formData = new FormData(f);
        // $(".loading-sec").addClass('active');
        this.modalOpen('alert',msgCon);
        oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", [""]);
        formData.append("description", document.getElementById("ir1").value);
        
        const sendData = Object.fromEntries(formData.entries());
        fetch('/study'+ url,{
            method: methodType,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
            },
            body: JSON.stringify(sendData)
        })
        .then(res => {
            return res.json();
        })
        .then(data => { 
            // alert("성공:" + data.msg);
            if(data.state === 'success'){
                this.modalHide('alert');
                this.modalResponseHidden(data.msg+"<br>",'success', 'response');
                console.log(data);
                let idVal = data.id === ''? '':"/"+data.id;
                setTimeout(() => {
                    window.location.href = `/study${idVal}`;
                }, 1000);

            }else{
                this.modalOpen('alert-btn',data.msg, 'btn-include');
            }
        })
        .catch(err => {
            console.log("실패:", err);
            this.modalOpen('alert-btn','실패', 'btn-include');
        });
    },

    // validate function

    // 종료날짜 > 시작날짜 비활성화
    dateDisabled(){
        $("#start-date").datepicker({
                dateFormat: "yy-mm-dd",
                showAnim: "slideDown",
                onSelect: function(selectedDate) {
                    // end date 최소 날짜 설정
                    $("#end-date").datepicker("option", "minDate", selectedDate);
                }
        });
    
        $("#end-date").datepicker({
            dateFormat: "yy-mm-dd",
            showAnim: "slideDown"
        });
    
        $("#deadLine").datepicker({
            dateFormat: "yy-mm-dd",
            showAnim: "slideDown",
            minDate: new Date()
        });
    },
    // 모집인원 추가 버튼
    addCount(num=0){
        let curVal = num === 0 ? 0 : parseInt($("input[name='recruited-num']").val());
        $("input[name='recruited-num']").val(curVal + num);
    }
}
