<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(IndicatorsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(MunicipalitiesTableSeeder::class);
        $this->call(DocumentsTableSeeder::class);
        $this->call(VoucherTypeSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(LiabilitiesTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(TaxesTableSeeder::class);
        $this->call(RegimesTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(CardsTableSeeder::class);
        $this->call(NcDiscrepanciesTableSeeder::class);
        $this->call(NdDiscrepanciesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(PaymentFormsTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VerificationCodeTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(UnitMeasuresTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PercentagesTableSeeder::class);
        $this->call(BranchProductsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(TypeGenerationsTableSeeder::class);
        //$this->call(TypeDocumentSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(MenuSeeder::class);
    }
}
