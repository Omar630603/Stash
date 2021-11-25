describe("Registertion + log out", () => {
    beforeEach(() => {
        cy.exec("php artisan migrate:fresh");
        cy.exec("php artisan db:seed");
    });
    it("Register new user", () => {
        cy.visit("/register");

        cy.get(
            ":nth-child(2) > :nth-child(1) > .input-group > .form-floating > .form-control"
        )
            .type("Ali")
            .should("have.value", "Ali");
        cy.get(
            ":nth-child(2) > :nth-child(2) > .input-group > .form-floating > .form-control"
        )
            .type("Ali123")
            .should("have.value", "Ali123");
        cy.get(".col-sm-12 > .input-group > .form-floating > .form-control")
            .type("Ali@email.com")
            .should("have.value", "Ali@email.com");
        cy.get(
            ":nth-child(4) > :nth-child(2) > .input-group > .form-floating > .form-control"
        )
            .type("Sana'a, Yemen")
            .should("have.value", "Sana'a, Yemen");
        cy.get(
            ":nth-child(4) > :nth-child(1) > .input-group > .form-floating > .form-control"
        )
            .type("967777300466")
            .should("have.value", "967777300466");
        cy.get(
            ":nth-child(5) > :nth-child(1) > .input-group > .form-floating > .form-control"
        )
            .type("123456789")
            .should("have.value", "123456789");
        cy.get(
            ":nth-child(5) > :nth-child(2) > .input-group > .form-floating > .form-control"
        )
            .type("123456789")
            .should("have.value", "123456789");

        cy.get("#register-btn").click();

        cy.get("#navbarDropdown").click();
        cy.get("#logout-btn").click();
    });
});
