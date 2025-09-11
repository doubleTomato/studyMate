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
    }
}
