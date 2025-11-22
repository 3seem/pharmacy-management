<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ------------------ User Triggers ------------------
        DB::unprepared("
            CREATE TRIGGER trg_user_after_insert
            AFTER INSERT ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, new_values, changed_by, description)
                VALUES (
                    'User',
                    NEW.id,
                    'INSERT',
                    JSON_OBJECT(
                        'id', NEW.id,
                        'name', NEW.name,
                        'email', NEW.email,
                        'role', NEW.role,
                        'is_active', NEW.is_active
                    ),
                    @current_id,
                    'User created'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_user_after_update
            AFTER UPDATE ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, new_values, changed_by, description)
                VALUES (
                    'User',
                    NEW.id,
                    'UPDATE',
                    JSON_OBJECT(
                        'name', OLD.name,
                        'email', OLD.email,
                        'role', OLD.role,
                        'is_active', OLD.is_active
                    ),
                    JSON_OBJECT(
                        'name', NEW.name,
                        'email', NEW.email,
                        'role', NEW.role,
                        'is_active', NEW.is_active
                    ),
                    @current_id,
                    'User updated'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_user_after_delete
            AFTER DELETE ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, changed_by, description)
                VALUES (
                    'User',
                    OLD.id,
                    'DELETE',
                    JSON_OBJECT(
                        'id', OLD.id,
                        'name', OLD.name,
                        'email', OLD.email,
                        'role', OLD.role
                    ),
                    @current_id,
                    'User deleted'
                );
            END;
        ");

        // ------------------ Employee Triggers ------------------
        DB::unprepared("
            CREATE TRIGGER trg_employee_after_insert
            AFTER INSERT ON `employees`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, new_values, changed_by, description)
                VALUES (
                    'Employee',
                    NEW.id,
                    'INSERT',
                    JSON_OBJECT(
                        'id', NEW.id,
                        'Salary', NEW.Salary,
                        'Hire_Date', NEW.Hire_Date,
                        'position', NEW.position
                    ),
                    @current_id,
                    'Employee record created'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_employee_after_update
            AFTER UPDATE ON `employees`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, new_values, changed_by, description)
                VALUES (
                    'Employee',
                    NEW.id,
                    'UPDATE',
                    JSON_OBJECT(
                        'Salary', OLD.Salary,
                        'position', OLD.position,
                        'employment_status', OLD.employment_status
                    ),
                    JSON_OBJECT(
                        'Salary', NEW.Salary,
                        'position', NEW.position,
                        'employment_status', NEW.employment_status
                    ),
                    @current_id,
                    'Employee updated'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_employee_after_delete
            AFTER DELETE ON `employees`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, changed_by, description)
                VALUES (
                    'Employee',
                    OLD.id,
                    'DELETE',
                    JSON_OBJECT(
                        'id', OLD.id,
                        'position', OLD.position
                    ),
                    @current_id,
                    'Employee deleted'
                );
            END;
        ");

        // ------------------ Customer Triggers ------------------
        DB::unprepared("
            CREATE TRIGGER trg_customer_after_insert
            AFTER INSERT ON `customers`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, new_values, changed_by, description)
                VALUES (
                    'Customer',
                    NEW.id,
                    'INSERT',
                    JSON_OBJECT(
                        'id', NEW.id,
                        'DOB', NEW.DOB,
                        'loyalty_points', NEW.loyalty_points
                    ),
                    @current_id,
                    'Customer created'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_customer_after_update
            AFTER UPDATE ON `customers`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, new_values, changed_by, description)
                VALUES (
                    'Customer',
                    NEW.id,
                    'UPDATE',
                    JSON_OBJECT(
                        'DOB', OLD.DOB,
                        'loyalty_points', OLD.loyalty_points
                    ),
                    JSON_OBJECT(
                        'DOB', NEW.DOB,
                        'loyalty_points', NEW.loyalty_points
                    ),
                    @current_id,
                    'Customer updated'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_customer_after_delete
            AFTER DELETE ON `customers`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, changed_by, description)
                VALUES (
                    'Customer',
                    OLD.id,
                    'DELETE',
                    JSON_OBJECT(
                        'id', OLD.id
                    ),
                    @current_id,
                    'Customer deleted'
                );
            END;
        ");

        // ------------------ Medicine Triggers ------------------
        DB::unprepared("
            CREATE TRIGGER trg_medicine_after_insert
            AFTER INSERT ON `medicine`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, new_values, changed_by, description)
                VALUES (
                    'Medicine',
                    NEW.medicine_id,
                    'INSERT',
                    JSON_OBJECT(
                        'medicine_id', NEW.medicine_id,
                        'Name', NEW.Name,
                        'Price', NEW.Price,
                        'is_active', NEW.is_active
                    ),
                    @current_id,
                    'Medicine created'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_medicine_after_update
            AFTER UPDATE ON `medicine`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, new_values, changed_by, description)
                VALUES (
                    'Medicine',
                    NEW.medicine_id,
                    'UPDATE',
                    JSON_OBJECT(
                        'Name', OLD.Name,
                        'Price', OLD.Price,
                        'is_active', OLD.is_active
                    ),
                    JSON_OBJECT(
                        'Name', NEW.Name,
                        'Price', NEW.Price,
                        'is_active', NEW.is_active
                    ),
                    @current_id,
                    'Medicine updated'
                );

                IF (OLD.Price IS NULL AND NEW.Price IS NOT NULL) OR (OLD.Price IS NOT NULL AND OLD.Price <> NEW.Price) THEN
                    INSERT INTO Price_Change_Log (medicine_id, old_price, new_price, changed_by, reason)
                    VALUES (NEW.medicine_id, COALESCE(OLD.Price, 0), NEW.Price, @current_id, 'Price change via UPDATE');
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_medicine_after_delete
            AFTER DELETE ON `medicine`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, changed_by, description)
                VALUES (
                    'Medicine',
                    OLD.medicine_id,
                    'DELETE',
                    JSON_OBJECT(
                        'medicine_id', OLD.medicine_id,
                        'Name', OLD.Name,
                        'Price', OLD.Price
                    ),
                    @current_id,
                    'Medicine deleted'
                );
            END;
        ");

        // ------------------ Batches Triggers ------------------
        DB::unprepared("
            CREATE TRIGGER trg_batches_after_insert
            AFTER INSERT ON `batches`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, new_values, changed_by, description)
                VALUES (
                    'Batches',
                    NEW.batch_number,
                    'INSERT',
                    JSON_OBJECT(
                        'batch_number', NEW.batch_number,
                        'medicine_id', NEW.medicine_id,
                        'current_stock', NEW.current_stock,
                        'exp_date', NEW.exp_date
                    ),
                    @current_id,
                    'Batch created'
                );
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_batches_after_update
            AFTER UPDATE ON `batches`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, new_values, changed_by, description)
                VALUES (
                    'Batches',
                    NEW.batch_number,
                    'UPDATE',
                    JSON_OBJECT(
                        'medicine_id', OLD.medicine_id,
                        'current_stock', OLD.current_stock,
                        'exp_date', OLD.exp_date
                    ),
                    JSON_OBJECT(
                        'medicine_id', NEW.medicine_id,
                        'current_stock', NEW.current_stock,
                        'exp_date', NEW.exp_date
                    ),
                    @current_id,
                    'Batch updated'
                );

                IF (OLD.current_stock IS NULL AND NEW.current_stock IS NOT NULL) OR (OLD.current_stock IS NOT NULL AND OLD.current_stock <> NEW.current_stock) THEN
                    INSERT INTO Stock_Adjustment_Log (batch_number, previous_stock, new_stock, `difference`, adjusted_by, reason)
                    VALUES (
                        NEW.batch_number,
                        COALESCE(OLD.current_stock, 0),
                        COALESCE(NEW.current_stock, 0),
                        COALESCE(NEW.current_stock, 0) - COALESCE(OLD.current_stock, 0),
                        @current_id,
                        'Stock updated'
                    );
                END IF;
            END;
        ");

        DB::unprepared("
            CREATE TRIGGER trg_batches_after_delete
            AFTER DELETE ON `batches`
            FOR EACH ROW
            BEGIN
                INSERT INTO Audit_Log (table_name, record_id, action, old_values, changed_by, description)
                VALUES (
                    'Batches',
                    OLD.batch_number,
                    'DELETE',
                    JSON_OBJECT(
                        'batch_number', OLD.batch_number,
                        'medicine_id', OLD.medicine_id,
                        'current_stock', OLD.current_stock
                    ),
                    @current_id,
                    'Batch deleted'
                );
            END;
        ");

        // ------------------ Other tables (orders, order_items, purchase_orders, suppliers, returns) ------------------
        // Follow same pattern: insert triggers with correct primary key columns
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $triggers = [
            'trg_user_after_insert',
            'trg_user_after_update',
            'trg_user_after_delete',
            'trg_employee_after_insert',
            'trg_employee_after_update',
            'trg_employee_after_delete',
            'trg_customer_after_insert',
            'trg_customer_after_update',
            'trg_customer_after_delete',
            'trg_medicine_after_insert',
            'trg_medicine_after_update',
            'trg_medicine_after_delete',
            'trg_batches_after_insert',
            'trg_batches_after_update',
            'trg_batches_after_delete',
            // Add other triggers here...
        ];

        foreach ($triggers as $trigger) {
            DB::unprepared("DROP TRIGGER IF EXISTS $trigger;");
        }
    }
};
