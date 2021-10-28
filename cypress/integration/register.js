describe("Registertion + log out", () => {
    beforeEach(() => {
        cy.exec("php artisan migrate:fresh");
        cy.exec("php artisan db:seed --class=CategoriesSeeder");
    });
    it("Register new user", () => {
        cy.visit("/register");

        cy.get("#name").type("fakeName").should("have.value", "fakeName");
        cy.get("#username")
            .type("fakeUsername")
            .should("have.value", "fakeUsername");
        cy.get("#email")
            .type("fake@email.com")
            .should("have.value", "fake@email.com");
        cy.get("#password")
            .type("fakePassword")
            .should("have.value", "fakePassword");
        cy.get("#password-confirm")
            .type("fakePassword")
            .should("have.value", "fakePassword");

        cy.get("#register-btn").click();

        cy.get("#navbarDropdown").click();
        cy.get("#logout-btn").click();
    });
});
