describe("Edit Admin Profile data", () => {
    it("Edit Data", () => {
        cy.visit("/login");
        cy.get("#login")
            .type("fakeUsername")
            .should("have.value", "fakeUsername");
        cy.get("#password")
            .type("fakePassword")
            .should("have.value", "fakePassword");
        cy.get("#login-btn").click();
        cy.visit("/home");
        cy.get("#edit-profile-btn").click();
        cy.get("input[name=name]")
            .clear()
            .type("Omar Al-Maktary")
            .should("have.value", "Omar Al-Maktary");
        cy.get("input[name=username]")
            .clear()
            .type("Omar")
            .should("have.value", "Omar");
        cy.get("input[name=email]")
            .clear()
            .type("omar.yem1111@email.com")
            .should("have.value", "omar.yem1111@email.com");
        cy.get("input[name=phone]")
            .clear()
            .type("+62082123533955")
            .should("have.value", "+62082123533955");
        cy.get("input[name=address]")
            .clear()
            .type("Suhat")
            .should("have.value", "Suhat");
        cy.get("#changeAdminProfile-btn").click();
    });
});
