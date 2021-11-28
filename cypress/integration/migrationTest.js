describe("Magrations Test", () => {
    it("Magrate tables into the test database", () => {
        cy.exec("php artisan migrate:refresh");
        cy.exec("php artisan db:seed");
    });
    it("load home page", () => {
        cy.visit("/");
    });
});
