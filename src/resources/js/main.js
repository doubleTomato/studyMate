// 인풋 관련 함수들
export const inputFunc = {
    requireConfirm(thisV){
        console.log(thisV);
    },
    categoryReturn(idV){ // 
        $.ajax({
            url: '/category/default',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('기본 카테고리:', data);

                let selectValue = "<option value=''>카테고리를 선택해주세요.</option>";

                data.forEach((v,i) => {
                    const {title, description} = v;
                    selectValue += `<option value="${i+1}" title="${description}">${title}</option>`;
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
            });
        }
    },

    //  form send
    sendData(f, methodType, url="") {
        let msgCon = url === "" ? "등록" : "수정";
        $(".loading-sec .msg-con").html(msgCon);
        if(methodType === 'DELETE' && !confirm("정말 삭제하시겠습니까? 복구할 수 없습니다.")){
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
        $(".loading-sec").show();
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
            alert("성공:" + data.msg);
            // console.log(data);
            $(".loading-sec").hide();
            let idVal = data.id === ''? '':"/"+data.id;
            window.location.href = `/study${idVal}`;
        })
        .catch(err => {
            console.log("실패:", err);
        });
    },
}
