define(['jquery', 'mage/url'], function ($, urlBuilder) {
    'use strict';

    $.widget('gustav.storeList', {
        options: {
            actionUrl: '/storelocator/frontend/storelist',
            currentPage: 1,
            pageSize: 5,
        },

        _create: function () {
            this._bindEvents();
            this._loadStores(this.options.currentPage);
        },

        _bindEvents: function () {
            const self = this;

            this.element.on('click', '.pagination a', function (event) {
                event.preventDefault();
                const page = $(this).data('page');

                self._loadStores(page);
            });

            $(document).on('change', '.category-filter', function () {
                self.options.currentPage = 1;
                const categoryId = $(this).val();

                self._loadStores(self.options.currentPage, categoryId);
                $(document).trigger('categoryFilterChanged', [categoryId]);
            });
        },

        _loadStores: function (page, categoryId = '') {
            const self = this;

            $.ajax({
                url: urlBuilder.build(this.options.actionUrl),
                type: 'GET',
                data: {
                    page: page,
                    limit: this.options.pageSize,
                    category: categoryId,
                },
                dataType: 'json',
                success: function (response) {
                    self.options.currentPage = page;
                    self._renderStores(response.stores);
                    self._renderPagination(response.total_count, page);
                },
                error: function (error) {
                    console.error('Error loading stores: ' + error.message);
                },
            });
        },

        _renderStores: function (stores) {
            let html = '<ul>';

            stores.forEach(function (store) {
                html += `<li>Name: ${store.name}</li>`;
            });

            html += '</ul>';
            this.element.html(html);
        },

        _renderPagination: function (totalCount, currentPage) {
            let pageCount = Math.ceil(totalCount / this.options.pageSize);
            let paginationHtml = '<div class="pagination">';

            if (currentPage > 1) {
                paginationHtml += `<a href="#" data-page="${
                    currentPage - 1
                }" class="action previous">&laquo; Back</a>`;
            }

            for (let i = 1; i <= pageCount; i++) {
                paginationHtml += `<a href="#" data-page="${i}" ${
                    currentPage === i ? 'class="current"' : ''
                }>${i}</a>`;
            }

            if (currentPage < pageCount) {
                paginationHtml += `<a href="#" data-page="${
                    currentPage + 1
                }" class="action next">Next &raquo;</a>`;
            }

            paginationHtml += '</div>';
            this.element.append(paginationHtml);
        },
    });

    return $.gustav.storeList;
});
