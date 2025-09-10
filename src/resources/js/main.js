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

                let selectValue = "";

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

                let selectValue = "";

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
    }

}
