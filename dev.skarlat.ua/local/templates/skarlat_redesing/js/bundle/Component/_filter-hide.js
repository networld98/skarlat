function hidefilter() {
    const filterFormGroupList = document.getElementsByClassName('filter__item-group');
    const showAllFilterList = document.querySelectorAll('.filter-all--show');

    if (filterFormGroupList && showAllFilterList) {

        showAllFilterList.forEach(function (element) {
            element.addEventListener('click', function () {

                element
                    .classList
                    .toggle('show');

                let elemtnParentLabel = this.parentElement.children;

                for (let item = 0; item < elemtnParentLabel.length - 1; item++) {

                    if (item > 4) {
                        elemtnParentLabel[item]
                            .classList
                            .toggle('filter__item--hiden');

                    }
                }
            });
        });

        //hide property filter
        for (let i in filterFormGroupList) {
            for (let j in filterFormGroupList[i].children) {
                if (j > 4 && j < filterFormGroupList[i].children.length - 1) {
                    filterFormGroupList[i]
                        .children[j]
                        .classList
                        .add('filter__item--hiden')
                }
            }
        }
    }
}
hidefilter();