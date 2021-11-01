describe("Magrations Test", () => {
    it("Magrate tables into the test database", () => {
        cy.exec("php artisan migrate");
        cy.exec("php artisan db:seed --class=CategoriesSeeder");
    });
    it("load home page", () => {
        cy.visit("/");
    });
});
