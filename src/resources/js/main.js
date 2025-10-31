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
    getConfirmData(msg, specifiedTxt=''){
        let returnData = '';
        returnData += `
            <h1>${msg}</h1>
            <p class="state-icon">
                <i class="${msg === '삭제'? 'xi-warning' : ''} xi-3x"></i>
            </p>
            <p>${msg === '삭제'? '정말로 삭제하시겠습니까?':specifiedTxt}</p>
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
    popupHide(){
        $(".modal-sec").hide();
    },
    modalHide(typeV){
        $(".loading-sec .msg." + typeV).hide();
        $(".loading-sec").removeClass("active");
    },
    confirmOpen(msg='', msgTxt = ''){
        return new Promise((resolve) => {
            const msgCon = msg === ''? '삭제': msg;
            const okBtn = document.getElementById('modal-ok-btn');
            const closeBtn = document.getElementById('modal-close-btn');
            this.modalOpen('confirm', msgCon, null, '', msgTxt);

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
    modalOpen(typeV ='', msg ='', state = null, type="", specifiedTxt=''){
        let returnData = '';
        if(typeV === 'response'){
            returnData = getDataFunc.getResponseData(msg, state, type);
        }else if(typeV === 'alert'){
            returnData = getDataFunc.getAlertData(msg);
        }else if(typeV === 'confirm'){
            returnData = getDataFunc.getConfirmData(msg, specifiedTxt);
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
    },async popupOpen(url){
        fetch( url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
            },
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network err');
            }
            return res.text()
        }).then(html=>{
            $(".modal-sec").css('display','block');
            $('.modal-sec').html(html);
        })
        .catch(err => {
            console.log("실패:", err);
            this.modalOpen('alert-btn','실패', 'btn-include');
        });
    },
    //  form send
    async sendData(f, methodType, url="") {
        let msgCon = url === "" ? "등록" : "수정";
        console.log(f);
        // if(methodType === 'DELETE' && !confirm("정말 삭제하시겠습니까? 복구할 수 없습니다.")){
        msgCon = methodType === 'DELETE' ? '삭제': msgCon;
        oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", [""]);
        if(methodType === 'DELETE' && !(await this.confirmOpen())){
            return;
        }
        if (!f.checkValidity()) {
            // alert("필수 값을 넣지 않았습니다. 입력값을 다시 확인해주세요!");
            this.modalOpen('alert-btn',"필수 값을 넣지 않았습니다.<br/>입력값을 다시 확인해주세요!", 'btn-include');
            return;
        }
        if($("#end-date").val() == '' && !$("#durationdisable").is(':checked')){
            // alert("종료 일자를 선택해주시거나 기간 제한 없음을 선택해주세요!");
            this.modalOpen('alert-btn',"종료 일자를 선택해주시거나<br/>기간 제한 없음을 선택해주세요!", 'btn-include');
            return;
        }if($("#region-sel").val() == '' && !$("#is-offline").is(":checked")){
            // alert("지역을 선택해주시거나 온라인 제한을 선택해주세요!");
            this.modalOpen('alert-btn',"지역을 선택해주시거나<br/> 온라인 제한을 선택해주세요!", 'btn-include');
            return;
        }
        if(document.getElementById("ir1").value ===''){
            // alert("지역을 선택해주시거나 온라인 제한을 선택해주세요!");
             this.modalOpen('alert-btn',"세부 내용을 입력해주세요!", 'btn-include');
            return;
        }
        const formData = new FormData(f);

        formData.append("description", document.getElementById("ir1").value);
        // $(".loading-sec").addClass('active');
        this.modalOpen('alert',msgCon);
        
        
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
    // f: form, methodType: ex) POST, DLETE..., url: 보낼 url, 
    // validateF: 유효성 검사 함수
   async commonSendForm(f, methodType, url, msg, validateF=null){

        if(methodType === 'DELETE' && !(await this.confirmOpen())){
            return;
        }

        const sendData = f===null? null :Object.fromEntries(f.entries())
        if(validateF ==! null && validateF()){
            return false;
        }

        this.modalOpen('alert', msg + ' 되는');
        
        fetch(url,{
            method: methodType,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
            },
            // body: JSON.stringify(sendData)
            body: sendData===null? null:JSON.stringify(sendData)
        })
        .then(res => {
            return res.json();
        })
        .then(data => { 
            this.modalHide('alert');
            this.popupHide();
            if(data.state === 'success'){
               this.modalOpen('alert-btn',data.msg,'btn-include');
               setTimeout(() => {
                    window.location.href = data.url;
                }, 2000);
            }else{
                console.log(data.errors);
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
    }, // 필터 변경 시
    async filterChange(isReset = '', isActive = false){
        let activeVal = '';
        if(isReset === 'r'){
            $("select[name='category']").prop('selectedIndex', 0).trigger('change');
            $("select[name='region']").prop('selectedIndex', 0).trigger('change');
            $("select[name='sort']").prop('selectedIndex', 0).trigger('change');
            $("input[name='search']").val('');
            $("input[name='pagination']").val(1);
            $("input[name='active']").val('false');
            $("#active-btn").removeClass("active");
        }

        let filter1 = isReset !== 'r' ? $("select[name='category']").val() : '';
        let filter2 = isReset !== 'r' ? $("select[name='region']").val() : '';
        let filter3 = isReset !== 'r' ? $("input[name='search']").val() : '';
        let filter4 = isReset !== 'r' ? $("select[name='sort']").val() : '';
        let filter5 = isReset !== 'r' ? $("input[name='pagination']").val() : 1;
        let filter6 = isReset !== 'r' ? $("input[name='active']").val() : '';


        this.modalOpen('alert','필터 적용');


        if(isReset == '' && isActive){
            if($("input[name='active']").val() === 'true'){
                filter6 = 'false';
                $("input[name='active']").val('false');
                $("#active-btn").removeClass("active");
            } else{
                filter6 = 'true';
                $("input[name='active']").val('true');
                $("#active-btn").addClass("active");
            }
        }

        const filters = {
                category: filter1,
                region: filter2,
                search: filter3,
                sort: filter4,
                pagination: filter5,
                active: filter6,
            }

         // Ajax 요청
            const res = await fetch('/studies/list', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(filters)
            });

            const html = await res.text();
            document.getElementById('study-list').innerHTML = html;

            // 페이지 번호 input 초기화
            $("input[name='pagination']").val(filters.pagination);
            this.modalHide('alert');
    },// 페이지네이션
    async paginationChange(aEl){
        if(!aEl) return;
        $(".loading-sec").addClass("active");
        e.preventDefault();
        const url = aEl.href;
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const html = await res.text();
        document.getElementById('study-list').innerHTML = html;
        const pageUrl = new URL(aEl.href);
        const page = pageUrl.searchParams.get('page'); 
        $("input[name='pagination']").val(page);
        $(".loading-sec").removeClass('active');
    },

}
