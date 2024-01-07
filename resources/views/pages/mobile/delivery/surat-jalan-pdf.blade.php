<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Surat Jalan</title>
</head>
<style>
	table{
		width: 100%;
	}

	table:not(.table-kop) tr td{
		vertical-align: top;
	}

	.text-center{
		text-align: center;
	}

	.text-right{
		text-align: right;
	}

	.fw-bold{
		font-weight: bold;
	}

	.kop td p{
		padding: 0px;
		margin: 0px;
	}

	.w-50{
		width: 50%;
	}
</style>
<body>
	<table class="table-kop">
		<tr class="kop">
			<td>
				<img src="{{public_path('assets/dist/img/nst.png')}}" alt="">
			</td>
			<td>
				<h1 class="text-center">PT. NAGA SINAR TERANG</h1>
				<p class="text-center fw-bold">FABRICATION, MACHINERY, PACKAGING & GENERAL TRADING</p>
				<p class="text-center">Delta Commercial Park 1, Jl. Kenari Jaya Blok B No.1 </p>
				<p class="text-center">Kawasan Industri Delta Silicon 6 Lippo Cikarang, Jayamukti, Cikarang Pusat 										
				</p>
				<p class="text-center">Bekasi, Jawa Barat, 17815  / Telp. 021 - 22157322, 021-22157067										
				</p>
			</td>
		</tr>
	</table>
	<div style="background-color: black;height: 3px;width: 100%;"></div>
	<table>
		<tr>
			<td class="fw-bold">SURAT JALAN</td>
			<td class="text-right">No. Dok: adsfadf</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<table style="border:1px solid black;">
					<tr>
						<td style="width:25%;">Kepada</td>
						<td style="width:2px">:</td>
						<td>PT Hafdsafasdf</td>
					</tr>
					<tr>
						<td style="width:25%;">Alamat</td>
						<td style="width:2px">:</td>
						<td>JL. Permata Raya Lot B - 6A Kawasan Industri KIIC Karawang 41361 Jawa Barat - Indonesia</td>
					</tr>
					<tr>
						<td style="width:25%;">No. Tel</td>
						<td style="width:2px">:</td>
						<td>022-3234234</td>
					</tr>
				</table>
			</td>
			<td>
				<table style="border:1px solid black;">
					<tr>
						<td style="width:25%;">Tanggal</td>
						<td style="width:2px">:</td>
						<td>PT Hafdsafasdf</td>
					</tr>
					<tr>
						<td style="width:25%;">No. Surat Jalan</td>
						<td style="width:2px">:</td>
						<td>JL. Permata Raya Lot B - 6A Kawasan Industri KIIC Karawang 41361 Jawa Barat - Indonesia</td>
					</tr>
					<tr>
						<td style="width:25%;">No. PO</td>
						<td style="width:2px">:</td>
						<td>022-3234234</td>
					</tr>
					<tr>
						<td style="width:25%;">No. Kendaraan</td>
						<td style="width:2px">:</td>
						<td>022-3234234</td>
					</tr>
					<tr>
						<td style="width:25%;">Driver</td>
						<td style="width:2px">:</td>
						<td>022-3234234</td>
					</tr>
				</table>	
			</td>
		</tr>
	</table>
	<style>
		.item{
			border-collapse: collapse;
			border: 1px solid black;
		}

		.item tr td, .item tr th{
			border: 1px solid black;
			text-align: center;
		}
	</style>
	<table class="item" style="margin-top:20px">
		<tr>
			<th>NO</th>
			<th>NAMA BARANG</th>
			<th>JUMLAH BARANG</th>
			<th>SATUAN</th>
			<th>KETERANGAN</th>
		</tr>
		@php
		$no=1;
		@endphp
		@foreach($item->delivered_stock as $item)
		<tr>
			<td>
				{{$no++}}
			</td>
			<td>{{$item->stock->material->name}}</td>
			<td>{{$item->stock->qty}}</td>
			<td>{{$item->stock->material->satuan}}</td>
			<td>{{$item->stock->description}}</td>
		</tr>
		@endforeach
	</table>
	<table>
		<tr>
			<td>
				<p class="text-center">Penerima</p>
				<p class="text-center" style="margin-top: 60px; border:1px solid black; margin-left: 10px;margin-right: 10px;"></p>
				<p style="margin-left: 10px;margin-right: 10px;">Tgl:</p>
			</td>
			<td>
				<p class="text-center">Mengetahui</p>
				<p class="text-center" style="margin-top: 60px; border:1px solid black; margin-left: 10px;margin-right: 10px;"></p>
				<p style="margin-left: 10px;margin-right: 10px;">Tgl:</p>
			</td>
			<td>
				<p class="text-center">Pengirim</p>
				<p class="text-center" style="margin-top: 60px; border:1px solid black; margin-left: 10px;margin-right: 10px;"></p>
				<p style="margin-left: 10px;margin-right: 10px;">Tgl:</p>
			</td>
		</tr>
	</table>
</body>
</html>