define(['jquery', 'mage/url'], function ($, urlBuilder) {
    'use strict';

    $.widget('gustav.storeList', {
        options: {
            actionUrl: '/storelocator/frontend/storelist',
            currentPage: 1,
            pageSize: 5,
            currentCategory: '',
        },

        _create: function () {
            this._bindEvents();
            this._loadStores(this.options.currentPage);
        },

        _bindEvents: function () {
            const self = this;

            $('.reset-filter-button').on('click', function () {
                $('.category-filter').val('');
                $('.store-search-input').val('');
                self.options.currentPage = 1;
                self.options.currentCategory = '';
                self._loadStores(self.options.currentPage);
            });

            this.element.on('click', '.pagination a', function (event) {
                event.preventDefault();
                const page = $(this).data('page');

                self._loadStores(page);
            });

            $(document).on('change', '.category-filter', function () {
                self.options.currentPage = 1;
                self.options.currentCategory = $(this).val();
                self._loadStores(
                    self.options.currentPage,
                    self.options.currentCategory
                );
            });

            $(document).on('input', '.store-search-input', function () {
                let searchTerm = $(this).val();

                self.options.currentPage = 1;
                if (searchTerm.length < 3 && searchTerm.length > 0) {
                    return;
                }
                self._loadStores(
                    self.options.currentPage,
                    self.options.currentCategory,
                    searchTerm
                );
            });
        },

        _loadStores: function (page, categoryId = '', searchQuery = '') {
            const self = this;

            $.ajax({
                url: urlBuilder.build(this.options.actionUrl),
                type: 'GET',
                data: {
                    page: page,
                    limit: this.options.pageSize,
                    category: categoryId,
                    search: searchQuery,
                },
                dataType: 'json',
                success: function (response) {
                    self.options.currentPage = page;
                    self._renderStores(response.stores);
                    self._renderPagination(response.total_count, page);
                    $(document).trigger('storeListUpdated', [response.stores]);
                },
                error: function (error) {
                    $('.js-store-list').text(
                        'Error loading stores: ' + error.message
                    );
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
