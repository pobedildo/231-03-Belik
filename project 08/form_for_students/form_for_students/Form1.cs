using System;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Windows.Forms;
using Newtonsoft.Json;

namespace form_for_students
{
    public partial class Form1 : Form
    {
        private int nextStudentId = 1;
        private DataTable studentsTable;
        private bool isDataModified = false;

        public Form1()
        {
            InitializeComponent();
            InitializeDataTable();
            InitializeDataGridViewColumns();
            this.FormClosing += new FormClosingEventHandler(Form1_FormClosing);
            InitializePhoneMask();
        }

        private void InitializePhoneMask()
        {
            maskedTextBoxPhone.Mask = "+7 (999) 000-00-00";
        }

        private void InitializeDataTable()
        {
            studentsTable = new DataTable();
            studentsTable.Columns.Add("ID", typeof(int));
            studentsTable.Columns.Add("Фамилия", typeof(string));
            studentsTable.Columns.Add("Имя", typeof(string));
            studentsTable.Columns.Add("Отчество", typeof(string));
            studentsTable.Columns.Add("Email", typeof(string));
            studentsTable.Columns.Add("Phone", typeof(string));
            studentsTable.Columns.Add("Курс", typeof(string));
            studentsTable.Columns.Add("Группа", typeof(string));
            studentsTable.Columns.Add("ДатаРождения", typeof(DateTime));
            dataGridView1.DataSource = studentsTable;
        }

        private void InitializeDataGridViewColumns()
        {
            dataGridView1.AutoGenerateColumns = false;
            dataGridView1.Columns.Clear();

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "ID",
                HeaderText = "ID",
                Width = 50,
                ReadOnly = true
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "Фамилия",
                HeaderText = "Фамилия",
                Width = 120
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "Имя",
                HeaderText = "Имя",
                Width = 100
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "Отчество",
                HeaderText = "Отчество",
                Width = 120
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "Email",
                HeaderText = "Email",
                Width = 180
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "Phone",
                HeaderText = "Телефон",
                Width = 120
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "Курс",
                HeaderText = "Курс",
                Width = 60
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "Группа",
                HeaderText = "Группа",
                Width = 80
            });

            dataGridView1.Columns.Add(new DataGridViewTextBoxColumn
            {
                DataPropertyName = "ДатаРождения",
                HeaderText = "Дата рождения",
                Width = 100,
                DefaultCellStyle = { Format = "dd.MM.yyyy" }
            });

            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                column.SortMode = DataGridViewColumnSortMode.Automatic;
            }
            dataGridView1.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
        }

        private void buttonAdd_Click(object sender, EventArgs e)
        {
            ResetHighlight();
            string surname = textBoxSurname.Text;
            string name = textBoxName.Text;
            string patronymic = textBoxPatronymic.Text;
            string email = textBoxEmail.Text;
            string phone = maskedTextBoxPhone.Text.Replace(" ", "").Replace("-", "").Replace("(", "").Replace(")", "");
            string course = textBoxCourse.Text;
            string group = textBoxGroup.Text;
            DateTime birthDate = dateTimePickerBirthDate.Value;

            bool hasErrors = false;

            if (string.IsNullOrEmpty(surname))
            {
                HighlightControl(textBoxSurname, "Фамилия не может быть пустой!");
                hasErrors = true;
            }

            if (string.IsNullOrEmpty(name))
            {
                HighlightControl(textBoxName, "Имя не может быть пустым!");
                hasErrors = true;
            }

            if (string.IsNullOrEmpty(patronymic))
            {
                HighlightControl(textBoxPatronymic, "Отчество не может быть пустым!");
                hasErrors = true;
            }

            if (string.IsNullOrEmpty(email))
            {
                HighlightControl(textBoxEmail, "Электронная почта не может быть пустой!");
                hasErrors = true;
            }
            else if (!IsValidEmail(email))
            {
                HighlightControl(textBoxEmail, "Некорректный формат электронной почты!");
                hasErrors = true;
            }

            if (string.IsNullOrEmpty(phone) || !maskedTextBoxPhone.MaskCompleted)
            {
                HighlightControl(maskedTextBoxPhone, "Телефонный номер не может быть пустым!");
                hasErrors = true;
            }

            if (string.IsNullOrEmpty(course))
            {
                HighlightControl(textBoxCourse, "Курс не может быть пустым!");
                hasErrors = true;
            }

            if (string.IsNullOrEmpty(group))
            {
                HighlightControl(textBoxGroup, "Группа не может быть пустой!");
                hasErrors = true;
            }

            if (hasErrors)
            {
                return;
            }

            studentsTable.Rows.Add(nextStudentId++, surname, name, patronymic, email, phone, course, group, birthDate);
            ClearInputFields();
            isDataModified = true;
            MessageBox.Show("Студент успешно добавлен!", "Успех", MessageBoxButtons.OK, MessageBoxIcon.Information);
        }

        private void buttonDelete_Click(object sender, EventArgs e)
        {
            if (dataGridView1.SelectedRows.Count > 0)
            {
                DialogResult result = MessageBox.Show(
                    "Вы уверены, что хотите удалить выбранного студента?",
                    "Подтверждение удаления",
                    MessageBoxButtons.YesNo,
                    MessageBoxIcon.Warning);

                if (result == DialogResult.Yes)
                {
                    studentsTable.Rows.RemoveAt(dataGridView1.SelectedRows[0].Index);
                    isDataModified = true;
                }
            }
            else
            {
                MessageBox.Show("Выберите студента для удаления!", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void HighlightControl(Control control, string message)
        {
            control.BackColor = Color.LightPink;
            MessageBox.Show(message, "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
        }

        private void ResetHighlight()
        {
            textBoxSurname.BackColor = SystemColors.Window;
            textBoxName.BackColor = SystemColors.Window;
            textBoxPatronymic.BackColor = SystemColors.Window;
            textBoxEmail.BackColor = SystemColors.Window;
            maskedTextBoxPhone.BackColor = SystemColors.Window;
            textBoxCourse.BackColor = SystemColors.Window;
            textBoxGroup.BackColor = SystemColors.Window;
        }

        private void ClearInputFields()
        {
            textBoxSurname.Clear();
            textBoxName.Clear();
            textBoxPatronymic.Clear();
            textBoxEmail.Clear();
            maskedTextBoxPhone.Clear();
            textBoxCourse.Clear();
            textBoxGroup.Clear();
            dateTimePickerBirthDate.Value = DateTime.Today;
        }

        private bool IsValidEmail(string email)
        {
            string pattern = @"^[a-zA-Z0-9._%+-]+@(yandex\.ru|gmail\.com|icloud\.com)$";
            return Regex.IsMatch(email, pattern);
        }

        private void sortBySurnameToolStripMenuItem_Click(object sender, EventArgs e)
        {
            studentsTable.DefaultView.Sort = "Фамилия ASC";
            dataGridView1.DataSource = studentsTable.DefaultView;
        }

        private void sortByNameToolStripMenuItem_Click(object sender, EventArgs e)
        {
            studentsTable.DefaultView.Sort = "Имя ASC";
            dataGridView1.DataSource = studentsTable.DefaultView;
        }

        private void sortByGroupToolStripMenuItem_Click(object sender, EventArgs e)
        {
            studentsTable.DefaultView.Sort = "Группа ASC";
            dataGridView1.DataSource = studentsTable.DefaultView;
        }

        private void sortByBirthDateToolStripMenuItem_Click(object sender, EventArgs e)
        {
            studentsTable.DefaultView.Sort = "Дата рождения ASC";
            dataGridView1.DataSource = studentsTable.DefaultView;
        }

        private void sortByCourseToolStripMenuItem_Click(object sender, EventArgs e)
        {
            studentsTable.DefaultView.Sort = "Курс ASC";
            dataGridView1.DataSource = studentsTable.DefaultView;
        }

        private void saveDataToolStripMenuItem_Click(object sender, EventArgs e)
        {
            SaveFileDialog saveFileDialog = new SaveFileDialog
            {
                Filter = "JSON Files (*.json)|*.json",
                Title = "Сохранить данные"
            };

            if (saveFileDialog.ShowDialog() == DialogResult.OK)
            {
                try
                {
                    var dataToSave = new
                    {
                        Version = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss"),
                        Data = studentsTable
                    };
                    string json = JsonConvert.SerializeObject(dataToSave, Formatting.Indented);
                    File.WriteAllText(saveFileDialog.FileName, json);
                    MessageBox.Show("Данные успешно сохранены!", "Успех", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    isDataModified = false;
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Ошибка при сохранении данных: {ex.Message}", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void loadDataToolStripMenuItem_Click(object sender, EventArgs e)
        {
            OpenFileDialog openFileDialog = new OpenFileDialog
            {
                Filter = "JSON Files (*.json)|*.json",
                Title = "Загрузить данные"
            };

            if (openFileDialog.ShowDialog() == DialogResult.OK)
            {
                try
                {
                    string json = File.ReadAllText(openFileDialog.FileName);
                    var loadedData = JsonConvert.DeserializeAnonymousType(json, new
                    {
                        Version = "",
                        Data = new DataTable()
                    });

                    if (loadedData == null || loadedData.Data == null)
                    {
                        MessageBox.Show("Неверный формат файла!", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        return;
                    }

                    studentsTable.Clear();
                    foreach (DataRow row in loadedData.Data.Rows)
                    {
                        studentsTable.ImportRow(row);
                    }

                    MessageBox.Show($"Данные успешно загружены! Версия: {loadedData.Version}", "Успех", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    isDataModified = false;
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Ошибка при загрузке данных: {ex.Message}", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (isDataModified)
            {
                DialogResult result = MessageBox.Show(
                    "Вы внесли изменения. Сохранить данные перед закрытием?",
                    "Подтверждение",
                    MessageBoxButtons.YesNoCancel,
                    MessageBoxIcon.Warning
                );

                if (result == DialogResult.Yes)
                {
                    saveDataToolStripMenuItem_Click(null, null);
                    e.Cancel = isDataModified;
                }
                else if (result == DialogResult.Cancel)
                {
                    e.Cancel = true;
                }
            }
        }

        private void filterByCourseToolStripMenuItem_Click(object sender, EventArgs e)
        {
            string course = Microsoft.VisualBasic.Interaction.InputBox("Введите курс для фильтрации:", "Фильтр по курсу");
            if (!string.IsNullOrEmpty(course))
            {
                studentsTable.DefaultView.RowFilter = $"Курс = '{course}'";
                dataGridView1.DataSource = studentsTable.DefaultView;
            }
        }

        private void filterByGroupToolStripMenuItem_Click(object sender, EventArgs e)
        {
            string group = Microsoft.VisualBasic.Interaction.InputBox("Введите группу для фильтрации:", "Фильтр по группе");
            if (!string.IsNullOrEmpty(group))
            {
                studentsTable.DefaultView.RowFilter = $"Группа = '{group}'";
                dataGridView1.DataSource = studentsTable.DefaultView;
            }
        }

        private void searchBySurnameToolStripMenuItem_Click(object sender, EventArgs e)
        {
            string surname = Microsoft.VisualBasic.Interaction.InputBox("Введите фамилию для поиска:", "Поиск по фамилии");
            if (!string.IsNullOrEmpty(surname))
            {
                studentsTable.DefaultView.RowFilter = $"Фамилия LIKE '%{surname}%'";
                dataGridView1.DataSource = studentsTable.DefaultView;
            }
        }

        private void searchByNameToolStripMenuItem_Click(object sender, EventArgs e)
        {
            string name = Microsoft.VisualBasic.Interaction.InputBox("Введите имя для поиска:", "Поиск по имени");
            if (!string.IsNullOrEmpty(name))
            {
                studentsTable.DefaultView.RowFilter = $"Имя LIKE '%{name}%'";
                dataGridView1.DataSource = studentsTable.DefaultView;
            }
        }

        private void importCsvToolStripMenuItem_Click(object sender, EventArgs e)
        {
            OpenFileDialog openFileDialog = new OpenFileDialog
            {
                Filter = "CSV Files (*.csv)|*.csv",
                Title = "Импорт данных из CSV"
            };

            if (openFileDialog.ShowDialog() == DialogResult.OK)
            {
                try
                {
                    studentsTable.Rows.Clear();

                    using (StreamReader reader = new StreamReader(openFileDialog.FileName))
                    {
                        string line;
                        bool isFirstLine = true;

                        while ((line = reader.ReadLine()) != null)
                        {
                            if (isFirstLine)
                            {
                                isFirstLine = false;
                                continue;
                            }

                            string[] values = line.Split(',');

                            if (values.Length == studentsTable.Columns.Count)
                            {
                                studentsTable.Rows.Add(values);
                            }
                        }
                    }

                    MessageBox.Show("Данные успешно импортированы!", "Успех", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Ошибка при импорте данных: {ex.Message}", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void exportCsvToolStripMenuItem_Click(object sender, EventArgs e)
        {
            SaveFileDialog saveFileDialog = new SaveFileDialog
            {
                Filter = "CSV Files (*.csv)|*.csv",
                Title = "Экспорт данных в CSV"
            };

            if (saveFileDialog.ShowDialog() == DialogResult.OK)
            {
                try
                {
                    using (StreamWriter writer = new StreamWriter(saveFileDialog.FileName, false, new UTF8Encoding(true)))
                    {
                        var headers = studentsTable.Columns.Cast<DataColumn>().Select(column => column.ColumnName);
                        writer.WriteLine(string.Join(",", headers));

                        foreach (DataRow row in studentsTable.Rows)
                        {
                            var fields = row.ItemArray.Select(field => field.ToString());
                            writer.WriteLine(string.Join(",", fields));
                        }
                    }

                    MessageBox.Show("Данные успешно экспортированы!", "Успех", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
                catch (Exception ex)
                {
                    MessageBox.Show($"Ошибка при экспорте данных: {ex.Message}", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void statisticsToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (studentsTable.Rows.Count == 0)
            {
                MessageBox.Show("Нет данных для анализа.", "Информация", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            try
            {
                var courseStatistics = studentsTable.AsEnumerable()
                    .Where(row => int.TryParse(row.Field<string>("Курс"), out _))
                    .GroupBy(row => int.Parse(row.Field<string>("Курс")))
                    .ToDictionary(group => group.Key, group => group.Count());

                var groupStatistics = studentsTable.AsEnumerable()
                    .Where(row => !string.IsNullOrEmpty(row.Field<string>("Группа")))
                    .GroupBy(row => row.Field<string>("Группа"))
                    .ToDictionary(group => group.Key, group => group.Count());

                StringBuilder result = new StringBuilder();
                result.AppendLine("Статистика по курсам:");
                foreach (var course in courseStatistics)
                {
                    result.AppendLine($"Курс {course.Key}: {course.Value} студентов");
                }

                result.AppendLine("Статистика по группам:");
                foreach (var group in groupStatistics)
                {
                    result.AppendLine($"Группа {group.Key}: {group.Value} студентов");
                }

                MessageBox.Show(result.ToString(), "Статистика", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            catch (Exception ex)
            {
                MessageBox.Show($"Ошибка при вычислении статистики: {ex.Message}", "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
        }
    }
}